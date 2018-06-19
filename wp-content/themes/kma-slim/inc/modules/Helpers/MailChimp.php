<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 11/28/2017
 * Time: 1:54 PM
 */

namespace Includes\Modules\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MailChimp
{
    protected $apiKey;
    protected $listId;
    protected $dc;

    public function __construct()
    {
        $this->apiKey = MAILCHIMP_API_KEY;
        $this->listId = MAILCHIMP_LIST_ID;
        $this->dc     = MAILCHIMP_GEO;
    }

    protected function connectToAPI()
    {
        $client = new Client([
            'base_uri' => 'https://' . $this->dc . '.api.mailchimp.com/',
            'auth'     => [ 'apikey' , $this->apiKey ],
        ]);

        return $client;
    }

    protected function hashEmail( $emailAddress ){
        return md5(strtolower($emailAddress));
    }

    public function addSubscriber( $emailAddress, $data)
    {
        $headers = [
            'Accept'     => 'application/json'
        ];

        $options = [
            $headers,
            'body' => json_encode([
                'email_address' => $emailAddress,
                'status'        => 'subscribed'
            ])
        ];

        $api = $this->connectToAPI();

        try{
            $api->post('/3.0/lists/' . $this->listId . '/members', (isset($data) ? $data : $options));
            $success = true;
        }catch(\Exception $e) {
            echo '<pre>',print_r($e->getResponse()->getBody()->getContents(), TRUE),'</pre>';
            $success = false;
        }
    }

    public function updateSubscriber( $emailAddress, $data)
    {
        $headers = [
            'Accept'     => 'application/json'
        ];

        $options = [
            $headers,
            'body' => json_encode([
                'status'        => 'subscribed'
            ])
        ];

        $api = $this->connectToAPI();

        try{
            $api->patch('/3.0/lists/' . $this->listId . '/members/' . $this->hashEmail($emailAddress), (isset($data) ? $data : $options));
            $success = true;
        }catch(\Exception $e) {
            echo '<pre>',print_r($e->getResponse()->getBody()->getContents(), TRUE),'</pre>';
            $success = false;
        }
    }

    public function handleSubscriber( $emailAddress )
    {
        $api = $this->connectToAPI();
        $md5Email = $this->hashEmail( $emailAddress );

        try {
            $request = $api->request('GET', '/3.0/lists/' . $this->listId . '/members/' . $md5Email);

            $result = json_decode($request->getBody()->getContents());
            $status = $result->status;

            $response = $status;

        } catch (ClientException $e) {

            $response = 'new';

        }

        return $response;
    }

    public function getInterestOptions($interestGroup = '865c3e5ba4')
    {
        $api = $this->connectToAPI();

        try {
            $request = $api->request('GET', '/3.0/lists/' . $this->listId . '/interest-categories/' . $interestGroup . '/interests/?count=100');

            $result = json_decode($request->getBody()->getContents());

            //echo '<pre class="has-text-left">',print_r($result),'</pre>';

            return $result;
            
        } catch (ClientException $e) {

            echo '<pre>',print_r($e),'</pre>';

        }

    }

    /*
    * Sorts nested objects by thier name
    */
    public function sortInterests($a, $b)
    {
        if ($a->name == $b->name) {
            return 0;
        }
        return ($a->name < $b->name) ? -1 : 1;
    }

    public function displayInterestOptions()
    {
        $interestGroup = $this->getInterestOptions();
        $interests = $interestGroup->interests;
        
        uasort($interests, array($this, 'sortInterests'));

        $numInterests = count($interests);
        $oneThird = round($numInterests / 3);
        $twoThirds = 2 * $oneThird;
        $i = 0;

        $output = '<div class="mc-field-group columns is-multiline has-text-left is-gapless">';

        foreach($interests as $interest){
            if($i == 0 || $i == $oneThird || $i == $twoThirds){
                $output .= '<div class="column is-12-tablet is-6-desktop is-4-widescreen">';
            }

            $output .= '
            <label class="checkbox">
                <input type="checkbox" name="'.$interest->category_id.'['.$interest->id.']" id="'.$interest->id.'">
                <span class="check-box"></span> '.$interest->name.'
            </label>';
            $i++;

            if($i == 0 || $i == $oneThird || $i == $twoThirds){
                $output .= '</div>';
            }
        }

        $output .= '</div></div>';

        return $output;
    }
}