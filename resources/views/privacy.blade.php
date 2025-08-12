<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechnoSpeak - Privacy Policy</title>
    <link rel="stylesheet" href="@secureAsset('style/home.css')" type="text/css">
    <link rel="stylesheet" href="@secureAsset('style/policy&terms.css')" type="text/css">
    <link rel="stylesheet" href="@secureAsset('style/about.css')" type="text/css">
    <link rel="stylesheet" href="@secureAsset('style/footer.css')" type="text/css">
    <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
</head>
<body>
    {{-- Include the navbar --}}
    @include('layouts.navbar', ['whiteBg' => $whiteBg ?? true])
    
    <main class="legal-docs-container">
        <header class="legal-header">
            <h1>Privacy Policy</h1>
            <p class="last-updated">Last Updated: July 08, 2025</p>
        </header>

        <article class="legal-content">
            <section>
                <h2>1. Introduction</h2>
                <p>TechnoSpeak (a subsidiary of Velisa Africa) provides online technology tutorials to help users navigate digital tools efficiently. We are committed to protecting your personal data in compliance with:</p>
                <ul>
                    <li>South Africa's <strong>Protection of Personal Information Act (POPIA)</strong>.</li>
                    <li>The EU <strong>General Data Protection Regulation (GDPR)</strong>.</li>
                </ul>
                <p>By using <a href="https://technospeak.co.za">technospeak.co.za</a>, you consent to this policy.</p>
            </section>

            <section>
                <h2>2. Data We Collect</h2>
                <h3>a) User Account Data:</h3>
                <ul>
                    <li>Name, surname, and email address (for account creation)</li>
                    <li>Course progress, quiz results, and certifications</li>
                </ul>
                
                <h3>b) Payment Data:</h3>
                <p>Processed securely via <strong>Stripe</strong> (we do not store credit card details)</p>
                
                <h3>c) Automated Data:</h3>
                <ul>
                    <li>IP address, browser type, and device information (via cookies)</li>
                    <li>Analytics on tutorial engagement (e.g., videos watched, time spent)</li>
                </ul>
            </section>

            <section>
                <h2>3. How We Use Your Data</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Purpose</th>
                            <th>Legal Basis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Deliver tutorials and certifications</td>
                            <td>Contract (GDPR Art. 6(1)(b))</td>
                        </tr>
                        <tr>
                            <td>Process payments via Stripe</td>
                            <td>Legal obligation (GDPR Art. 6(1)(c))</td>
                        </tr>
                        <tr>
                            <td>Improve user experience</td>
                            <td>Legitimate interest (GDPR Art. 6(1)(f))</td>
                        </tr>
                        <tr>
                            <td>Send service-related emails</td>
                            <td>Consent (GDPR Art. 6(1)(a))</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Continue with other sections from your policy -->
            
            <section>
                <h2>9. Policy Updates</h2>
                <p>Changes will be posted on <a href="https://technospeak.co.za">technospeak.co.za</a>.</p>
            </section>
        </article>
    </main>

    <!-- Footer Section -->
    {{-- Include the footer --}}
    @include('layouts.footer')
</body>
</html>