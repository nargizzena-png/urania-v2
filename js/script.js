// === BURGER MENU ===
const burger = document.getElementById('open-menu');
const nav    = document.getElementById('site-nav');

if (burger && nav) {
    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        nav.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
    });

    // Close menu when any nav link is clicked
    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            burger.classList.remove('active');
            nav.classList.remove('active');
            document.body.classList.remove('no-scroll');
        });
    });
}

// === SCROLL REVEAL via IntersectionObserver ===
const revealEls = document.querySelectorAll('.reveal');

if (revealEls.length > 0) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

    revealEls.forEach(el => observer.observe(el));
}

// === CONTACT FORM HANDLING ===
const contactForm = document.getElementById('contactForm');
const formSuccess = document.getElementById('formSuccess');
const formError = document.getElementById('formError');

if (contactForm) {
    // Real-time validation feedback
    const inputs = contactForm.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });

    // Form submission
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate all fields
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            showFormError('Te rugăm să corectezi erorile din formular.');
            return;
        }
        
        // Disable submit button
        const submitBtn = contactForm.querySelector('.form-submit');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Se trimite...</span>';
        
        try {
            const formData = new FormData(contactForm);
            
            const response = await fetch('contact-submit.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Hide form, show success message
                contactForm.style.display = 'none';
                if (formError) formError.style.display = 'none';
                if (formSuccess) {
                    formSuccess.style.display = 'block';
                    formSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                // Reset form for future use
                contactForm.reset();
            } else {
                showFormError(result.message || 'A apărut o eroare. Te rugăm să încerci din nou.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        } catch (error) {
            console.error('Form submission error:', error);
            showFormError('A apărut o eroare de conexiune. Te rugăm să încerci din nou.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
}

function validateField(field) {
    const formGroup = field.closest('.form-group');
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error state
    field.classList.remove('error');
    const existingError = formGroup.querySelector('.field-error');
    if (existingError) existingError.remove();
    
    // Check required
    if (field.hasAttribute('required') && !field.value.trim()) {
        isValid = false;
        errorMessage = 'Acest câmp este obligatoriu.';
    }
    
    // Validate email
    if (field.type === 'email' && field.value) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(field.value)) {
            isValid = false;
            errorMessage = 'Adresa de email nu este validă.';
        }
    }
    
    // Validate phone
    if (field.type === 'tel' && field.value) {
        const phonePattern = /^[0-9\s\+\-\(\)]{10,20}$/;
        if (!phonePattern.test(field.value)) {
            isValid = false;
            errorMessage = 'Numărul de telefon nu este valid.';
        }
    }
    
    // Validate name (letters only)
    if (field.id === 'name' && field.value) {
        const namePattern = /^[\p{L}\s\-]+$/u;
        if (!namePattern.test(field.value)) {
            isValid = false;
            errorMessage = 'Numele poate conține doar litere.';
        }
    }
    
    // Validate minimum word count for message (at least 2 words)
    if (field.id === 'message' && field.value) {
        const wordCount = field.value.trim().split(/\s+/).filter(word => word.length > 0).length;
        if (wordCount < 2) {
            isValid = false;
            errorMessage = 'Mesajul trebuie să conțină cel puțin două cuvinte.';
        }
    }
    
    // Validate checkbox
    if (field.type === 'checkbox' && field.hasAttribute('required') && !field.checked) {
        isValid = false;
        errorMessage = 'Trebuie să accepți pentru a continua.';
    }
    
    if (!isValid) {
        field.classList.add('error');
        const errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        errorEl.textContent = errorMessage;
        errorEl.style.cssText = 'color: #dc3545; font-size: 0.8rem; margin-top: 5px; display: block;';
        formGroup.appendChild(errorEl);
    }
    
    return isValid;
}

function showFormError(message) {
    if (formError) {
        formError.querySelector('p').textContent = message;
        formError.style.display = 'block';
        formError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Add CSS for form error states dynamically
const formErrorStyles = document.createElement('style');
formErrorStyles.textContent = `
    .form-group input.error,
    .form-group textarea.error,
    .form-group select.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }
    
    .form-group input.error:focus,
    .form-group textarea.error:focus,
    .form-group select.error:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2) !important;
    }
`;
document.head.appendChild(formErrorStyles);
