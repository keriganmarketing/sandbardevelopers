<div class="projects has-text-centered">
    <div class="container">
        <h2 class="title is-2">Featured Projects</h2>
        <div class="columns is-multiline">
            <?php
                foreach(getProjects(null,4) as $project){
                    $client = get_the_terms($project['id'], 'client')[0];
                    include(locate_template('template-parts/partials/mini-project.php'));
                }
            ?>
        </div>
    </div>
    <div class="section-cta has-text-centered">
        <a href="/projects/" class="button is-primary is-round is-caps" >View Project Gallery</a>
    </div>
</div>