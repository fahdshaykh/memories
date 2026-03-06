<footer id="eskimo-footer">
    <div class="container">
        <div class="row eskimo-footer-wrapper">
            <!-- FOOTER WIDGET 1 -->
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <h5 class="eskimo-title-with-border"><span>About Me</span></h5>
                <p>Trusted by thousands of customers, my unique themes and plugins help you make beautiful responsive web sites with ease.</p>
                <p><a href="{{ url('about') }}" class="btn btn-default">Read More</a></p>
            </div>
            <!-- FOOTER WIDGET 2 -->
            <div class="col-12 col-lg-6">
                <h5 class="eskimo-title-with-border"><span>Newsletter</span></h5>
                <form method="post" action="{{ route('subscribe') }}" id="newsletter-form">
                    @csrf
                    <label>Subscribe to our mailing list!</label>
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" id="subscribe-email" placeholder="Your email address" required />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" id="subscribe-btn">
                                <span id="btn-text">Sign up</span>
                                <span id="btn-spinner" class="d-none">
                                    <span class="spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div id="newsletter-message"></div>
                </form>
            </div>
        </div>
        <!-- CREDITS -->
        <div class="eskimo-footer-credits">
            <div class="row">
                <div class="col-6">
                    <p>
                        Since 2024 &copy; <a href="{{ url('/') }}">Wisherpro</a>. All rights reserved.
                    </p>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('faq') }}">FAQ</a> |
                    <a href="{{ route('user-guide') }}">User guide</a> |
                    <a href="{{ route('terms') }}">Terms of Service</a> |
                    <a href="{{ route('contact') }}">Contact Us</a> |
                    <a href="{{ route('privacy-policy') }}">Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- AJAX Newsletter Script --}}
<script>
(function() {
    'use strict';

    // Wait for DOM to be ready
    function initNewsletterForm() {
        const form = document.getElementById('newsletter-form');
        if (!form) return;

        const emailInput = document.getElementById('subscribe-email');
        const submitBtn = document.getElementById('subscribe-btn');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const messageDiv = document.getElementById('newsletter-message');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Validate email
            const email = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email || !emailRegex.test(email)) {
                showMessage('Please enter a valid email address.', 'danger');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            btnText.classList.add('d-none');
            btnSpinner.classList.remove('d-none');
            messageDiv.innerHTML = '';

            // Send AJAX request
            const formData = new FormData(form);

            fetch("{{ route('subscribe') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    form.reset();
                } else {
                    showMessage(data.message || 'Something went wrong. Please try again.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred. Please try again.', 'danger');
            })
            .finally(() => {
                submitBtn.disabled = false;
                btnText.classList.remove('d-none');
                btnSpinner.classList.add('d-none');
            });
        });

        function showMessage(message, type) {
            messageDiv.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                message +
                '</div>';

            // Auto dismiss after 5 seconds for success messages
            if (type === 'success') {
                setTimeout(() => {
                    const alert = messageDiv.querySelector('.alert');
                    if (alert) {
                        alert.remove();
                    }
                }, 5000);
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNewsletterForm);
    } else {
        initNewsletterForm();
    }
})();
</script>

<style>
.btn-spinner {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: middle;
    border: 0.25em currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite;
}

@keyframes spinner-border {
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}
</style>
