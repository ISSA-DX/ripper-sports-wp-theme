<?php
/**
 * Template Name: Contact
 *
 * The contact page template.
 *
 * @package Ripper_Sports
 */

get_header();
?>

<!-- Page title -->
<section class="relative pt-32 pb-16 md-pt-40 md-pb-24 bg-gradient-to-b from-shield-20 to-background border-b border-white-10">
  <div class="container">
    <div class="max-w-3xl">
      <span class="tag mb-4"><?php esc_html_e( 'Contact', 'ripper-sports' ); ?></span>
      <h1 class="text-display text-cream mb-6"><?php the_title(); ?></h1>
      <?php if ( has_excerpt() ) : ?>
        <div class="text-body-lg text-muted">
          <?php the_excerpt(); ?>
        </div>
      <?php else : ?>
        <p class="text-body-lg text-muted">
          <?php esc_html_e( 'Got a tip, a partnership idea, or a question about our coverage? We read every message and aim to respond within two business days.', 'ripper-sports' ); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>

<main id="main-content" class="section">
  <div class="container">
    <div class="grid grid-cols-1 lg-grid-cols-12 gap-6 items-start">

      <!-- Contact form -->
      <section class="lg-col-span-8 bg-black-20 border border-white-10 p-6 md-p-10">
        <form class="js-contact-form space-y-6" action="#" method="post" novalidate data-ajax-action="ripper_sports_contact">
          <div class="grid grid-cols-1 md-grid-cols-2 gap-6">
            <div class="form-group">
              <label for="contact-name" class="form-label"><?php esc_html_e( 'Name', 'ripper-sports' ); ?></label>
              <input id="contact-name" type="text" name="name" class="form-input" required autocomplete="name" aria-describedby="name-hint">
              <p id="name-hint" class="form-hint"><?php esc_html_e( 'How should we address you?', 'ripper-sports' ); ?></p>
              <p class="form-error"><?php esc_html_e( 'Please enter your name.', 'ripper-sports' ); ?></p>
            </div>
            <div class="form-group">
              <label for="contact-email" class="form-label"><?php esc_html_e( 'Email', 'ripper-sports' ); ?></label>
              <input id="contact-email" type="email" name="email" class="form-input" required autocomplete="email" aria-describedby="email-hint">
              <p id="email-hint" class="form-hint"><?php esc_html_e( 'We will never share your address.', 'ripper-sports' ); ?></p>
              <p class="form-error"><?php esc_html_e( 'Please enter a valid email address.', 'ripper-sports' ); ?></p>
            </div>
          </div>

          <div class="form-group">
            <label for="contact-topic" class="form-label"><?php esc_html_e( 'Topic', 'ripper-sports' ); ?></label>
            <select id="contact-topic" name="topic" class="form-select" required>
              <option value="" disabled selected><?php esc_html_e( 'Choose a topic', 'ripper-sports' ); ?></option>
              <option value="editorial"><?php esc_html_e( 'Editorial / News Tip', 'ripper-sports' ); ?></option>
              <option value="partnership"><?php esc_html_e( 'Partnership / Advertising', 'ripper-sports' ); ?></option>
              <option value="technical"><?php esc_html_e( 'Technical Support', 'ripper-sports' ); ?></option>
              <option value="feedback"><?php esc_html_e( 'Site Feedback', 'ripper-sports' ); ?></option>
              <option value="other"><?php esc_html_e( 'Other', 'ripper-sports' ); ?></option>
            </select>
          </div>

          <div class="form-group">
            <label for="contact-message" class="form-label"><?php esc_html_e( 'Message', 'ripper-sports' ); ?></label>
            <textarea id="contact-message" name="message" rows="8" class="form-textarea" required minlength="20" maxlength="2000" aria-describedby="message-hint"></textarea>
            <p id="message-hint" class="form-hint"><?php esc_html_e( 'Keep it between 20 and 2000 characters.', 'ripper-sports' ); ?></p>
            <p class="form-error"><?php esc_html_e( 'Please enter a message.', 'ripper-sports' ); ?></p>
          </div>

          <div class="form-group flex items-start gap-3">
            <input id="contact-consent" type="checkbox" name="consent" class="form-checkbox mt-1" required>
            <label for="contact-consent" class="text-body-sm text-muted">
              <?php
              printf(
                /* translators: %s: privacy policy link */
                esc_html__( 'I agree to Ripper Sports processing my personal data in line with the %s.', 'ripper-sports' ),
                '<a href="' . esc_url( get_permalink( get_page_by_path( 'privacy' ) ) ) . '" class="text-secondary hover-text-gold underline">' . esc_html__( 'Privacy Policy', 'ripper-sports' ) . '</a>'
              );
              ?>
            </label>
            <p class="form-error"><?php esc_html_e( 'Please agree to the privacy policy.', 'ripper-sports' ); ?></p>
          </div>

          <button type="submit" class="btn btn-primary btn-lg">
            <span class="btn-text"><?php esc_html_e( 'Send Message', 'ripper-sports' ); ?></span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
            </svg>
          </button>

          <div class="form-status js-form-status" role="status" aria-live="polite"></div>
        </form>
      </section>

      <!-- Sidebar -->
      <aside class="lg-col-span-4 space-y-6">
        <div class="bg-black-20 border border-white-10 p-6">
          <h2 class="text-headline-md text-cream mb-4"><?php esc_html_e( 'Other Ways to Reach Us', 'ripper-sports' ); ?></h2>
          <ul class="space-y-4 text-body-md text-muted">
            <li class="flex items-start gap-3">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-secondary flex-shrink-0 mt-1">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
              </svg>
              <span>editorial@rippersports.example.com</span>
            </li>
            <li class="flex items-start gap-3">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-secondary flex-shrink-0 mt-1">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
              </svg>
              <span>Suite 400, Melbourne Sports Media Centre, VIC 3000</span>
            </li>
          </ul>
        </div>

        <div class="bg-shield-10 border-2 border-shield-30 p-6">
          <h3 class="text-label text-secondary mb-2"><?php esc_html_e( 'Media Inquiries', 'ripper-sports' ); ?></h3>
          <p class="text-body-md text-muted mb-4"><?php esc_html_e( 'Looking for press passes, interview access, or brand assets?', 'ripper-sports' ); ?></p>
          <a href="mailto:media@rippersports.example.com" class="btn btn-secondary w-full"><?php esc_html_e( 'Email Media Team', 'ripper-sports' ); ?></a>
        </div>
      </aside>
    </div>
  </div>
</main>

<?php
get_footer();
