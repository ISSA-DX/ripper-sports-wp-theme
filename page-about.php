<?php
/**
 * Template Name: About
 *
 * The About page template — editorial mission, by-the-numbers,
 * coverage areas, team, methodology, and contact CTAs.
 *
 * @package Ripper_Sports
 */

get_header();
?>

<!-- Page title / hero band -->
<section class="relative pt-32 pb-16 md-pt-40 md-pb-24 bg-gradient-to-b from-shield-20 to-background border-b border-white-10">
  <div class="container">
    <div class="max-w-3xl reveal">
      <span class="tag mb-4"><?php esc_html_e( 'About Ripper Sports', 'ripper-sports' ); ?></span>
      <h1 class="text-display text-cream mb-6"><?php the_title(); ?></h1>
      <p class="text-body-lg text-muted">
        <?php
        if ( has_excerpt() ) {
            echo esc_html( get_the_excerpt() );
        } else {
            esc_html_e( 'Bold Australian sports journalism, real-time data, and unmissable highlights — built for fans who want the full story, not just the scoreline.', 'ripper-sports' );
        }
        ?>
      </p>
    </div>
  </div>
</section>

<main id="main-content" class="section pt-0">

  <!-- Section B — Our Story / Mission -->
  <div class="container">
    <div class="grid grid-cols-1 lg-grid-cols-12 gap-6">
      <div class="lg-col-span-4 reveal-left">
        <span class="page-kicker"><?php esc_html_e( 'Our Story', 'ripper-sports' ); ?></span>
        <h2 class="section-title section-title-accent mt-4">
          <?php esc_html_e( 'Why We Rip In', 'ripper-sports' ); ?>
        </h2>
      </div>
      <div class="lg-col-span-8 reveal-right">
        <p class="text-body-lg text-cream mb-6">
          <?php esc_html_e( 'Ripper Sports exists because Australian sport deserves coverage that matches its ferocity. From the bounce of an AFL grand final to the slow burn of a Boxing Day Test, we cover every beat with the same brief: tell the truth, find the angle nobody else is chasing, and respect the reader’s time.', 'ripper-sports' ); ?>
        </p>
        <p class="text-body-lg text-muted">
          <?php esc_html_e( 'We started as a one-person newsroom chasing tips, transfers and fixture changes faster than the legacy outlets. Today we run a small, independent desk of writers, analysts and data nerds, working out of Melbourne and contributing from every state. We are proudly independent, ad-light, and reader-funded.', 'ripper-sports' ); ?>
        </p>
        <div class="mt-8 flex flex-wrap gap-4">
          <a href="#newsletter" class="btn btn-primary"><?php esc_html_e( 'Subscribe to The Ripper Report', 'ripper-sports' ); ?></a>
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Send Us a Tip', 'ripper-sports' ); ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Section C — By the Numbers -->
  <section class="section">
    <div class="container">
      <div class="section-header reveal">
        <span class="page-kicker"><?php esc_html_e( 'By the Numbers', 'ripper-sports' ); ?></span>
        <h2 class="section-title section-title-accent">
          <?php esc_html_e( 'The Ripper Report at a Glance', 'ripper-sports' ); ?>
        </h2>
      </div>
      <div class="stat-grid mt-12 reveal-stagger">
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Sports Covered', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight">10+</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'From AFL to Formula 1®', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Publishing Cadence', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight">24/7</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'Match-day live coverage', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Editorial Independence', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight">100%</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'No paywall, no pay-to-play', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Headquarters', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight">MEL</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'Melbourne, VIC — with contributors nationwide', 'ripper-sports' ); ?></span>
        </div>
      </div>
    </div>
  </section>

  <!-- Section D — What We Cover -->
  <section class="section pt-0">
    <div class="container">
      <div class="section-header reveal">
        <span class="page-kicker"><?php esc_html_e( 'What We Cover', 'ripper-sports' ); ?></span>
        <h2 class="section-title section-title-accent">
          <?php esc_html_e( 'Every Code, Every Court, Every Track', 'ripper-sports' ); ?>
        </h2>
        <?php
        $sports_page_id = get_page_by_path( 'sports' );
        if ( $sports_page_id ) : ?>
          <a href="<?php echo esc_url( get_permalink( $sports_page_id ) ); ?>" class="section-link">
            <?php esc_html_e( 'View All Sports', 'ripper-sports' ); ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
          </a>
        <?php endif; ?>
      </div>
      <?php
      $cover_sports = get_terms(
          array(
              'taxonomy'   => 'sport',
              'hide_empty' => false,
              'number'     => 6,
              'orderby'    => 'name',
              'order'      => 'ASC',
          )
      );
      if ( ! empty( $cover_sports ) && ! is_wp_error( $cover_sports ) ) : ?>
        <div class="grid-auto mt-12 reveal-stagger">
          <?php foreach ( $cover_sports as $sport ) : ?>
            <a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="card">
              <div class="card-body">
                <span class="card-tag"><?php echo esc_html( $sport->name ); ?></span>
                <h3 class="card-title"><?php echo esc_html( $sport->name ); ?> <?php esc_html_e( 'Coverage', 'ripper-sports' ); ?></h3>
                <p class="card-excerpt"><?php esc_html_e( 'Latest news, analysis and highlights from across the code.', 'ripper-sports' ); ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

</main>

<!-- Section E — Editorial Pillars (on banded surface) -->
<section class="section bg-primary-container border-y border-white-10">
  <div class="container">
    <div class="section-header reveal">
      <span class="page-kicker"><?php esc_html_e( 'Editorial Pillars', 'ripper-sports' ); ?></span>
      <h2 class="section-title section-title-accent">
        <?php esc_html_e( 'What We Stand For', 'ripper-sports' ); ?>
      </h2>
    </div>
    <div class="grid grid-cols-1 md-grid-cols-3 gap-6 mt-12 reveal-stagger">

      <div class="bg-black-20 border border-white-10 p-6 md-p-8">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" class="text-secondary mb-4" aria-hidden="true">
          <path d="M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-3z"/>
        </svg>
        <span class="text-label text-secondary"><?php esc_html_e( 'Pillar 01', 'ripper-sports' ); ?></span>
        <h3 class="text-headline-md text-cream mt-2 mb-3"><?php esc_html_e( 'Independence', 'ripper-sports' ); ?></h3>
        <p class="text-body-md text-muted"><?php esc_html_e( 'No club ownership, no league sponsorship, no pay-for-coverage. Our only stakeholder is the reader.', 'ripper-sports' ); ?></p>
      </div>

      <div class="bg-black-20 border border-white-10 p-6 md-p-8">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" class="text-secondary mb-4" aria-hidden="true">
          <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <span class="text-label text-secondary"><?php esc_html_e( 'Pillar 02', 'ripper-sports' ); ?></span>
        <h3 class="text-headline-md text-cream mt-2 mb-3"><?php esc_html_e( 'Verification', 'ripper-sports' ); ?></h3>
        <p class="text-body-md text-muted"><?php esc_html_e( 'Every stat is sourced, every quote is on the record, every transfer is double-checked. We publish corrections in the open.', 'ripper-sports' ); ?></p>
      </div>

      <div class="bg-black-20 border border-white-10 p-6 md-p-8">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" class="text-secondary mb-4" aria-hidden="true">
          <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
        </svg>
        <span class="text-label text-secondary"><?php esc_html_e( 'Pillar 03', 'ripper-sports' ); ?></span>
        <h3 class="text-headline-md text-cream mt-2 mb-3"><?php esc_html_e( 'Fan-First', 'ripper-sports' ); ?></h3>
        <p class="text-body-md text-muted"><?php esc_html_e( 'We write for the people who actually watch, attend and argue about the game — not for the press-release audience.', 'ripper-sports' ); ?></p>
      </div>

    </div>
  </div>
</section>

<main id="main-content-2" class="section">

  <!-- Section F — Meet the Desk -->
  <div class="container">
    <div class="section-header reveal">
      <span class="page-kicker"><?php esc_html_e( 'Meet the Desk', 'ripper-sports' ); ?></span>
      <h2 class="section-title section-title-accent">
        <?php esc_html_e( 'The Rippers Behind the Report', 'ripper-sports' ); ?>
      </h2>
    </div>

    <div class="grid grid-cols-1 md-grid-cols-2 lg-grid-cols-4 gap-6 mt-12 reveal-stagger">

      <article class="card">
        <div class="card-image" style="aspect-ratio: 1 / 1; background: var(--rs-shield-30); display: flex; align-items: center; justify-content: center;">
          <svg viewBox="0 0 100 100" width="60%" height="60%" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
            <circle cx="50" cy="38" r="18" fill="var(--rs-cream, #f3f0e6)"/>
            <path d="M20 92 C 20 66, 80 66, 80 92 Z" fill="var(--rs-cream, #f3f0e6)"/>
          </svg>
        </div>
        <div class="card-body">
          <span class="card-tag"><?php esc_html_e( 'Editor-in-Chief', 'ripper-sports' ); ?></span>
          <h3 class="card-title">Maya Caldow</h3>
          <p class="card-excerpt"><?php esc_html_e( 'Leads editorial. Beat: AFLW, NRLW, and the long-form features nobody else has the runway to chase.', 'ripper-sports' ); ?></p>
        </div>
      </article>

      <article class="card">
        <div class="card-image" style="aspect-ratio: 1 / 1; background: var(--rs-shield-30); display: flex; align-items: center; justify-content: center;">
          <svg viewBox="0 0 100 100" width="60%" height="60%" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
            <circle cx="50" cy="38" r="18" fill="var(--rs-cream, #f3f0e6)"/>
            <path d="M20 92 C 20 66, 80 66, 80 92 Z" fill="var(--rs-cream, #f3f0e6)"/>
          </svg>
        </div>
        <div class="card-body">
          <span class="card-tag"><?php esc_html_e( 'Data Editor', 'ripper-sports' ); ?></span>
          <h3 class="card-title">Lachlan Nguyen</h3>
          <p class="card-excerpt"><?php esc_html_e( 'Builds the models that power our tipsters and live win-probability widgets. Cricket and tennis are his comfort zones.', 'ripper-sports' ); ?></p>
        </div>
      </article>

      <article class="card">
        <div class="card-image" style="aspect-ratio: 1 / 1; background: var(--rs-shield-30); display: flex; align-items: center; justify-content: center;">
          <svg viewBox="0 0 100 100" width="60%" height="60%" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
            <circle cx="50" cy="38" r="18" fill="var(--rs-cream, #f3f0e6)"/>
            <path d="M20 92 C 20 66, 80 66, 80 92 Z" fill="var(--rs-cream, #f3f0e6)"/>
          </svg>
        </div>
        <div class="card-body">
          <span class="card-tag"><?php esc_html_e( 'Motorsport Writer', 'ripper-sports' ); ?></span>
          <h3 class="card-title">Priya Devlin</h3>
          <p class="card-excerpt"><?php esc_html_e( 'Covers Formula 1®, Supercars and MotoGP from the paddock. Files live updates from Albert Park every March.', 'ripper-sports' ); ?></p>
        </div>
      </article>

      <article class="card">
        <div class="card-image" style="aspect-ratio: 1 / 1; background: var(--rs-shield-30); display: flex; align-items: center; justify-content: center;">
          <svg viewBox="0 0 100 100" width="60%" height="60%" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
            <circle cx="50" cy="38" r="18" fill="var(--rs-cream, #f3f0e6)"/>
            <path d="M20 92 C 20 66, 80 66, 80 92 Z" fill="var(--rs-cream, #f3f0e6)"/>
          </svg>
        </div>
        <div class="card-body">
          <span class="card-tag"><?php esc_html_e( 'Newsroom Reporter', 'ripper-sports' ); ?></span>
          <h3 class="card-title">Tom Beckett</h3>
          <p class="card-excerpt"><?php esc_html_e( 'Breaks transfer news and fixture changes. Soccer, A-League and the Socceroos are his daily bread.', 'ripper-sports' ); ?></p>
        </div>
      </article>

    </div>
  </div>

</main>

<!-- Section G — Editorial Standards / Methodology -->
<section class="section bg-black-20 border-y border-white-10">
  <div class="container">
    <div class="grid grid-cols-1 lg-grid-cols-12 gap-6 items-start">
      <div class="lg-col-span-4 reveal-left">
        <span class="page-kicker"><?php esc_html_e( 'Editorial Standards', 'ripper-sports' ); ?></span>
        <h2 class="section-title section-title-accent mt-4">
          <?php esc_html_e( 'How We Work', 'ripper-sports' ); ?>
        </h2>
        <p class="text-body-md text-muted mt-4">
          <?php esc_html_e( 'A short, honest read on what we publish, how we verify it, and what we do when we get it wrong.', 'ripper-sports' ); ?>
        </p>
      </div>
      <div class="lg-col-span-8 space-y-6 reveal-right">

        <div>
          <h3 class="text-headline-md text-cream mb-2"><?php esc_html_e( 'Sourcing', 'ripper-sports' ); ?></h3>
          <p class="text-body-md text-muted"><?php esc_html_e( 'We name our sources where we can. Where a source needs protection, we explain why — and we tell you what we could not verify on the record.', 'ripper-sports' ); ?></p>
        </div>

        <div>
          <h3 class="text-headline-md text-cream mb-2"><?php esc_html_e( 'Corrections', 'ripper-sports' ); ?></h3>
          <p class="text-body-md text-muted"><?php esc_html_e( 'When we get a name, score, or stat wrong, we fix it at the top of the article and note the change at the bottom. No silent edits on live stories.', 'ripper-sports' ); ?></p>
        </div>

        <div>
          <h3 class="text-headline-md text-cream mb-2"><?php esc_html_e( 'Conflicts of Interest', 'ripper-sports' ); ?></h3>
          <p class="text-body-md text-muted"><?php esc_html_e( 'Writers disclose any ticketing, hospitality or freelance work for clubs, leagues or agencies they cover. The editor decides what is and isn’t a conflict.', 'ripper-sports' ); ?></p>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Section H — Newsletter + Contact CTAs -->
<section class="section" id="newsletter">
  <div class="container">
    <div class="newsletter-box reveal-scale">
      <div class="newsletter-box-glow" aria-hidden="true"></div>
      <div class="newsletter-box-shield" aria-hidden="true"></div>
      <div class="relative z-10 grid grid-cols-1 lg-grid-cols-2 gap-8 items-center">
        <div>
          <span class="page-kicker"><?php esc_html_e( 'Stay in the Game', 'ripper-sports' ); ?></span>
          <h2 class="section-title section-title-accent mt-4">
            <?php esc_html_e( 'The Morning Ripper, in Your Inbox', 'ripper-sports' ); ?>
          </h2>
          <p class="text-body-lg text-muted mt-4">
            <?php esc_html_e( 'A 5-minute briefing every weekday morning: the overnight scores, the day’s fixtures, and the one story we think you should not miss. Free, independent, no spam.', 'ripper-sports' ); ?>
          </p>
        </div>
        <div>
          <form class="newsletter-inline js-newsletter-form" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
            <input type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Enter email address', 'ripper-sports' ); ?>" required aria-label="<?php esc_attr_e( 'Email address for newsletter', 'ripper-sports' ); ?>">
            <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Subscribe Free', 'ripper-sports' ); ?></button>
          </form>
          <div class="mt-6 flex flex-wrap items-center gap-3">
            <span class="text-body-sm text-muted"><?php esc_html_e( 'Got a tip instead?', 'ripper-sports' ); ?></span>
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-secondary">
              <?php esc_html_e( 'Contact the Newsroom', 'ripper-sports' ); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
