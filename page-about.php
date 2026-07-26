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
<section class="relative pt-32 pb-16 md-pt-40 md-pb-24 bg-gradient-to-b from-shield-20 to-background border-b border-white-10 overflow-hidden" data-drift="0.04">
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

<main id="main-content" class="section pt-0" data-drift="0.05">

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
          <span class="stat-value stat-value-highlight" data-counter data-counter-target="10" data-counter-suffix="+">10+</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'From AFL to Formula 1®', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Publishing Cadence', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight" data-counter-skip>24/7</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'Match-day live coverage', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Editorial Independence', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight" data-counter data-counter-target="100" data-counter-suffix="%">100%</span>
          <span class="text-body-sm text-muted mt-2"><?php esc_html_e( 'No paywall, no pay-to-play', 'ripper-sports' ); ?></span>
        </div>
        <div class="stat-card">
          <span class="stat-label"><?php esc_html_e( 'Headquarters', 'ripper-sports' ); ?></span>
          <span class="stat-value stat-value-highlight" data-counter-skip>MEL</span>
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
      if ( ! empty( $cover_sports ) && ! is_wp_error( $cover_sports ) ) :
        // Map sport slugs → realistic photo + tagline + accent colour.
        // Photos are sourced from Unsplash (consistent with the existing
        // fallback pattern in template-parts/content-card.php) so editorial
        // can swap them for first-party shots later without touching code.
        $sport_visuals = array(
          'afl'         => array(
            'image'   => 'https://images.unsplash.com/photo-1607627000458-210e8d2bdb1d?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Australian Football',
            'credit'  => 'Australian rules football',
          ),
          'nrl'         => array(
            'image'   => 'https://images.unsplash.com/photo-1579952063874-6a3bb8ba1f1f?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Rugby League',
            'credit'  => 'Rugby league match',
          ),
          'cricket'     => array(
            'image'   => 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Test, ODI & T20',
            'credit'  => 'Cricket batsman at the crease',
          ),
          'soccer'      => array(
            'image'   => 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'A-League & Socceroos',
            'credit'  => 'Football players in action',
          ),
          'basketball'  => array(
            'image'   => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'NBL & NCAA',
            'credit'  => 'Basketball game action shot',
          ),
          'rugby'       => array(
            'image'   => 'https://images.unsplash.com/photo-1579952063874-6a3bb8ba1f1f?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Wallabies & Super Rugby',
            'credit'  => 'Rugby union scrum',
          ),
          'tennis'      => array(
            'image'   => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'ATP & WTA Tour',
            'credit'  => 'Tennis player on court',
          ),
          'motorsport'  => array(
            'image'   => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Formula 1® & Supercars',
            'credit'  => 'Formula 1 car on track',
          ),
          'golf'        => array(
            'image'   => 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'PGA Tour & Majors',
            'credit'  => 'Golf course and club',
          ),
          'boxing-mma'  => array(
            'image'   => 'https://images.unsplash.com/photo-1517438476312-10d79c077509?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Boxing & UFC',
            'credit'  => 'Boxing training scene',
          ),
          'individual-sport' => array(
            'image'   => 'https://images.unsplash.com/photo-1517438476312-10d79c077509?auto=format&fit=crop&w=800&q=80',
            'tagline' => 'Boxing & UFC',
            'credit'  => 'Combat sports scene',
          ),
        );
        $default_visual = array(
          'image'   => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=800&q=80',
          'tagline' => 'Coverage',
          'credit'  => 'Sports scene',
        );
        ?>
        <div class="sport-card-grid mt-12 reveal-stagger">
          <?php
          foreach ( $cover_sports as $sport ) :
            $slug_key     = strtolower( $sport->slug );
            $visual       = isset( $sport_visuals[ $slug_key ] ) ? $sport_visuals[ $slug_key ] : $default_visual;
            $sport_class  = sanitize_html_class( 'sport-card--' . $slug_key );
            $count_text   = sprintf(
              /* translators: %d: number of posts in this sport */
              _n( '%d story', '%d stories', (int) $sport->count, 'ripper-sports' ),
              (int) $sport->count
            );
            ?>
            <a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="card sport-card <?php echo esc_attr( $sport_class ); ?>">
              <div class="sport-card-image">
                <img src="<?php echo esc_url( $visual['image'] ); ?>" alt="<?php echo esc_attr( $visual['credit'] ); ?>" loading="lazy" decoding="async">
                <span class="sport-card-tagline"><?php echo esc_html( $visual['tagline'] ); ?></span>
              </div>
              <div class="card-body">
                <span class="card-tag"><?php echo esc_html( $sport->name ); ?></span>
                <h3 class="card-title"><?php echo esc_html( $sport->name ); ?> <?php esc_html_e( 'Coverage', 'ripper-sports' ); ?></h3>
                <p class="card-excerpt"><?php echo esc_html( $count_text ); ?> published — <?php echo esc_html( $visual['tagline'] ); ?>.</p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

</main>

<!-- Section E — Editorial Pillars (on banded surface) -->
<section class="section bg-primary-container border-y border-white-10" data-drift="0.06">
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

      <article class="card" data-parallax="0.08">
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

      <article class="card" data-parallax="0.08">
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

      <article class="card" data-parallax="0.08">
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

      <article class="card" data-parallax="0.08">
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
