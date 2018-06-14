<div class="columns is-multiline is-gapless is-justified">
    <div class="column is-6-tablet is-4-widescreen has-text-centered team-photo is-flex-row is-justified-end">
        <div class="feature-box is-full-height is-flex-column is-justified-end is-aligned">
            <a class="button is-outlined is-round is-caps is-bold" href="/about/">Meet Our Team</a>
        </div>
    </div>
    <div class="column is-6-tablet is-4-widescreen services is-flex-row is-justified">
        <div class="feature-box is-full-height is-flex-column is-justified-between is-aligned">
            <h3 class="title is-2">Services</h3>
            <ul>
                <?php foreach(getServices(4) as $service){ ?>
                <li><a href="/services/#<?= $service->post_name; ?>"><?= $service->post_title; ?></a></li>
                <?php } ?>
            </ul>
            <a class="button is-outlined is-round is-caps is-bold" href="/services/">All Services</a>
        </div>
    </div>
    <div class="column is-4-widescreen clients is-flex-row is-justified-start">
        <div class="feature-box is-full-height is-flex-column is-justified-between is-aligned">
            <h3 class="title is-2">Clients</h3>
            <ul>
                <?php foreach (getClients(true, 4) as $client) { ?>
                <li><a href="/clients/#<?= $client->slug; ?>"><?= $client->name; ?></a></li>
                <?php } ?>
            </ul>
            <a class="button is-outlined is-round is-caps is-bold" href="/clients/">All Clients</a>
        </div>
    </div>
</div>