// ====================================
// ADMIN PANEL JAVASCRIPT
// File: admin/assets/admin.js
// ====================================

document.addEventListener('DOMContentLoaded', function() {
    
    // === CONFIRM DELETE === //
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const confirmDelete = confirm('Are you sure you want to delete this item? This action cannot be undone.');
            
            if (!confirmDelete) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // === FORM VALIDATION === //
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger)';
                } else {
                    field.style.borderColor = 'var(--light-gray)';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        });
    });
    
    // === FILE INPUT PREVIEW === //
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Show file name
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                // Create or update file info display
                let fileInfo = input.parentElement.querySelector('.file-info');
                
                if (!fileInfo) {
                    fileInfo = document.createElement('div');
                    fileInfo.className = 'file-info text-muted';
                    input.parentElement.appendChild(fileInfo);
                }
                
                fileInfo.textContent = fileName + ' (' + fileSize + ' MB)';
                
                // Preview image if it's an image input
                if (input.accept && input.accept.includes('image')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        let preview = input.parentElement.querySelector('.image-preview');
                        
                        if (!preview) {
                            preview = document.createElement('img');
                            preview.className = 'image-preview';
                            preview.style.maxWidth = '200px';
                            preview.style.marginTop = '12px';
                            preview.style.borderRadius = '8px';
                            input.parentElement.appendChild(preview);
                        }
                        
                        preview.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(file);
                }
            }
        });
    });
    
    // === AUTO-HIDE ALERTS === //
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
    
    // === ACTIVE MENU HIGHLIGHT === //
    const currentPage = window.location.pathname.split('/').pop();
    const menuLinks = document.querySelectorAll('.sidebar-menu a');
    
    menuLinks.forEach(function(link) {
        const linkPage = link.getAttribute('href');
        
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
    
    // === TABLE SORTING (basic) === //
    const tableHeaders = document.querySelectorAll('th[data-sortable]');
    
    tableHeaders.forEach(function(header) {
        header.style.cursor = 'pointer';
        header.title = 'Click to sort';
        
        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const columnIndex = Array.from(this.parentElement.children).indexOf(this);
            const isAscending = this.classList.contains('sort-asc');
            
            // Remove all sort classes
            tableHeaders.forEach(function(h) {
                h.classList.remove('sort-asc', 'sort-desc');
            });
            
            // Add appropriate sort class
            if (isAscending) {
                this.classList.add('sort-desc');
            } else {
                this.classList.add('sort-asc');
            }
            
            // Sort rows
            rows.sort(function(a, b) {
                const aValue = a.children[columnIndex].textContent.trim();
                const bValue = b.children[columnIndex].textContent.trim();
                
                if (isAscending) {
                    return bValue.localeCompare(aValue, undefined, { numeric: true });
                } else {
                    return aValue.localeCompare(bValue, undefined, { numeric: true });
                }
            });
            
            // Re-append rows
            rows.forEach(function(row) {
                tbody.appendChild(row);
            });
        });
    });
    
});

// === UTILITY FUNCTIONS === //

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Show confirmation
function confirmAction(message) {
    return confirm(message || 'Are you sure?');
}

// Show alert message
function showAlert(message, type) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-' + (type || 'info');
    alert.textContent = message;
    
    const content = document.querySelector('.content');
    if (content) {
        content.insertBefore(alert, content.firstChild);
        
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 3000);
    }
}
