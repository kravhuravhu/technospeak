<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechnoSpeak - Terms & Conditions</title>
    <link rel="stylesheet" href="style/policy&terms.css">
</head>
<body>
    {{-- Include the navbar --}}
    @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])
    
    <main class="legal-docs-container">
        <header class="legal-header">
            <h1>Terms & Conditions</h1>
            <p class="last-updated">Last Updated: July 08, 2025</p>
        </header>

        <article class="legal-content">
            <section>
                <h2>1. Acceptance of Terms</h2>
                <p>By using <a href="https://technospeak.co.za">technospeak.co.za</a>, you agree to these Terms.</p>
            </section>

            <section>
                <h2>2. Services</h2>
                <p>TechnoSpeak provides:</p>
                <ul>
                    <li>Pre-recorded video tutorials</li>
                    <li>Interactive quizzes and certifications</li>
                    <li>Email support at <a href="mailto:technospeakmails@gmail.com">technospeakmails@gmail.com</a></li>
                </ul>
            </section>

            <section>
                <h2>3. User Accounts</h2>
                <ul>
                    <li>You must provide accurate <strong>name, surname, and email</strong></li>
                    <li>Keep login credentials confidential</li>
                    <li>Accounts are non-transferable</li>
                </ul>
            </section>

            <section>
                <h2>4. Payments & Refunds</h2>
                <ul>
                    <li>All fees processed via <strong>Stripe</strong></li>
                    <li>Refunds may be requested within <strong>14 days</strong> if content is undelivered</li>
                    <li>No refunds for completed courses</li>
                </ul>
            </section>

            <section>
                <h2>5. Intellectual Property</h2>
                <ul>
                    <li>All tutorial content is owned by TechnoSpeak/Velisa Africa</li>
                    <li>No redistribution without written permission</li>
                    <li>Personal use license only</li>
                </ul>
            </section>

            <section>
                <h2>6. Limitation of Liability</h2>
                <p>TechnoSpeak is not liable for:</p>
                <ul>
                    <li>Indirect damages (e.g., lost profits)</li>
                    <li>Third-party actions (e.g., Stripe's payment errors)</li>
                    <li>Technical issues beyond our reasonable control</li>
                </ul>
            </section>

            <section>
                <h2>7. Termination</h2>
                <p>We may suspend accounts for:</p>
                <ul>
                    <li>Violating these Terms</li>
                    <li>Fraudulent activity</li>
                    <li>Abusive behavior</li>
                </ul>
            </section>

            <section>
                <h2>8. Governing Law</h2>
                <p>These Terms are governed by <strong>South African law</strong>.</p>
            </section>

            <section>
                <h2>9. Changes to Terms</h2>
                <p>Updates will be posted on <a href="https://technospeak.co.za">technospeak.co.za</a>.</p>
            </section>
        </article>
    </main>

    <!-- Footer Section -->
    {{-- Include the footer --}}
    @include('layouts.footer')
</body>
</html>