<?php

namespace Includes\Modules\Leads;

use Includes\Modules\Helpers\MailChimp;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class SubContractorSignup extends Leads
{
    public $requiredFields;
    public $errors;
    public $successMessage;

    public function __construct ()
    {
        parent::__construct ();
        parent::assembleLeadData(
            [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'company_name' => 'Company Name',
                'email_address' => 'Email Address',
                'phone_number' => 'Phone Number',
                'cell_number' => 'Cell Number',
                'fax_number' => 'Fax Number',
                'address' => 'Address'
            ]
        );
        parent::set('postType', 'Sub');
        parent::set('adminEmail', 'bryan@kerigan.com');

        $this->requiredFields = [
            'first_name' => 'text',
            'last_name'  => 'text',
            'email_address' => 'email',
            'phone_number' => 'phone',
            'cell_number' => 'phone',
            'addr1' => 'text',
            'city' => 'text',
            'state' => 'text',
            'zip' => 'text'
        ];

        $this->errors = [];

    }

    /**
     * Handle data submitted by lead form
     * @param array $dataSubmitted
     * @instructions pass $_POST to $dataSubmitted from template file
     */
    public function handleLead ($dataSubmitted = [])
    {
        $fullName = (isset($dataSubmitted['full_name']) ? $dataSubmitted['full_name'] : null);
        $dataSubmitted['full_name'] = (isset($dataSubmitted['first_name']) && isset($dataSubmitted['last_name']) ? $dataSubmitted['first_name'] . ' ' . $dataSubmitted['last_name'] : $fullName);
        $dataSubmitted['address'] = (isset($dataSubmitted['addr1']) ? $dataSubmitted['addr1'] : '') . ' ' . (isset($dataSubmitted['addr2']) ? $dataSubmitted['addr2'] : ''). '<br>' .
        (isset($dataSubmitted['city']) ? $dataSubmitted['city'] : '') . ', ' . (isset($dataSubmitted['state']) ? $dataSubmitted['state'] : '') . ' ' . (isset($dataSubmitted['zip']) ? $dataSubmitted['zip'] : '');

        //$this->addToDashboard($dataSubmitted);
        if(!$this->validateSubmission($dataSubmitted)){ return false; }
        //$this->addToDashboard($dataSubmitted);
        $this->sendToMailChimp($dataSubmitted);
        //$this->sendNotifications($dataSubmitted);

        return true;
    }

    protected function sendToMailChimp($dataSubmitted)
    {
        $mailChimp = new MailChimp();

        //check to see what status of email address is in MailChimp
        $response = $mailChimp->handleSubscriber($dataSubmitted['email_address']);

        switch ($response) {
            case 'new':
                $message = 'Thanks for registering for our bidder\'s list!';
                $this->addSubscriber($dataSubmitted, 'post');
                break;
            case 'subscribed':
                $message = 'You were already on our list, so we just updated your profile.';
                $this->addSubscriber($dataSubmitted, 'patch');
                break;
            case 'unsubscribed':
                $message = 'Glad to see you back. You have activated your registration once more.';
                $this->addSubscriber($dataSubmitted, 'patch');
                break;
            case 'cleaned':
                $message = 'Glad to see you back, but the provided email address has been purged from our records due to delivery issues. Consider using a different email address.';
                $this->addSubscriber($dataSubmitted, 'patch');
                break;
            case 'pending':
                $message = 'Your registration is still pending activation. Check your email for the verification link.';
                $this->addSubscriber($dataSubmitted, 'patch');
                break;
            default:
                $this->addSubscriber($dataSubmitted, 'patch');
                $message = 'Thanks for subscribing!';
            }

        $this->successMessage = $message;

        return true;
    }

    public function addSubscriber( $dataSubmitted, $method )
    {
        $mailChimp = new MailChimp();

        $headers = [
            'User-Agent' => 'testing/1.0',
            'Accept'     => 'application/json'
        ];

        $details = [
            'email_address' => $dataSubmitted['email_address'],
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME' => $dataSubmitted['first_name'],
                'LNAME' => $dataSubmitted['last_name'],
                'PHONE' => $dataSubmitted['phone_number'],
                'MMERGE7' => $dataSubmitted['cell_number'],
                'MMERGE5' => $dataSubmitted['fax_number'],
                'COMPANY' => $dataSubmitted['company_name'],
                'ADDRESS' => [
                    'addr1' => $dataSubmitted['addr1'],
                    'addr2' => $dataSubmitted['addr2'],
                    'city' => $dataSubmitted['city'],
                    'state' => $dataSubmitted['state'],
                    'zip' => $dataSubmitted['zip'],
                    'country' => $dataSubmitted['country']
                ]
            ]
        ];

        $interests = $mailChimp->getInterestOptions();

        foreach($interests->interests as $interest){
            if(isset($dataSubmitted[$interest->category_id][$interest->id]) && $dataSubmitted[$interest->category_id][$interest->id] == 'on') {
                $details['interests'][$interest->id] = true;
            }else{
                $details['interests'][$interest->id] = false;
            }
        }

        //echo '<pre class="has-text-left">',print_r($details),'</pre>';

        $options = [
            $headers,
            'body' => json_encode($details)
        ];
        
        if($method == 'post'){
            $mailChimp->addSubscriber($dataSubmitted['email_address'], $options);
        }elseif($method == 'patch'){
            $mailChimp->updateSubscriber($dataSubmitted['email_address'], $options);
        }
    }

    /*
     * Validate certain data types on the backend
     * @param array $dataSubmitted
     * @return boolean $passCheck
     */
    protected function validateSubmission($dataSubmitted)
    {

        $passCheck = true;

        //echo '<pre class="has-text-left" >',print_r($dataSubmitted),'</pre>';

        foreach($this->requiredFields as $field => $type){
            if($dataSubmitted[$field] == ''){
                $this->errors['blankfields'] = 'You left some required fields blank.';
                $passCheck = false;
            }else{
                if($type == 'email' && 
                !filter_var($dataSubmitted['email_address'], FILTER_VALIDATE_EMAIL) && 
                !preg_match('/@.+\./',  $dataSubmitted['email_address'])
                ){
                    $this->errors['bademail'] = 'You\'ve provided an email address that is improperly formatted.';
                    $passCheck = false;
                }
                //add more validation by type here if needed

            }
        }

        return $passCheck;

    }

    protected function showForm()
    {

        $mailChimp = new MailChimp();
        $interests = $mailChimp->displayInterestOptions();

        $form = file_get_contents(locate_template('template-parts/forms/sub-contractor-signup.php'));
        $form = str_replace('{interestOptions}',$interests,$form);
        $formSubmitted = (isset($_POST['sec']) ? ($_POST['sec'] == '' ? true : false) : false );

        ob_start();

        if($formSubmitted){
            if($this->handleLead($_POST)){
                return '<message title="Success" class="is-success">'.$this->successMessage.'</message>';
            }else{
                if(count($this->errors)>0) {
                    $errors = '<ul>';
                    foreach($this->errors as $key => $error){
                        $errors .= '<li>'.$error.'</li>';
                    }
                    $errors .='</ul>';
                }
                return '<message title="Error" class="is-danger"><p>There was an error with your submission. Please try again.</p>'.($errors!= '' ? $errors : '').'</message>';

                echo $form;

                return ob_get_clean();
            }
        }else{
            echo $form;

            return ob_get_clean();
        }
    }

    public function setupShortcode()
    {
        add_shortcode( 'signup_form', function( $atts ){
            return $this->showForm();
        } );
    }

}