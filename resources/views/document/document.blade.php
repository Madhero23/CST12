<!-- Google Fonts for Instrument Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
    rel="stylesheet">

@vite(['resources/css/document.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <div class="admin-documents">
            <div class="page-header">
                <h1 class="page-title">Document Management</h1>
            </div>

            <div class="doc-main-card" data-animate="fade-in">
                <div class="doc-section-header">
                    <h2 class="doc-section-title">Document Management</h2>
                    <div class="header-actions">
                        <button class="btn btn-outline" onclick="openTemplatesModal()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="10" rx="2" />
                                <path d="M7 11V7a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1" />
                            </svg>
                            <span>Manage Templates</span>
                        </button>
                        <button class="btn btn-outline" onclick="openUploadModal()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <span>Upload Document</span>
                        </button>
                        <button class="btn btn-primary" onclick="openNewQuotationModal()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>New Quotation</span>
                        </button>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-item" data-animate="fade-up">
                        <div class="stat-icon-wrapper" style="background-color: var(--fin-teal);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                <polyline points="14.5 2 14.5 8 20 8"></polyline>
                                <path d="m9 13 2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="stat-val">{{ $stats['active'] }}</div>
                        <div class="stat-txt">Active Quotations</div>
                    </div>
                    <div class="stat-item" data-animate="fade-up" style="animation-delay: 0.1s">
                        <div class="stat-icon-wrapper" style="background-color: #5fb1b7;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z">
                                </path>
                            </svg>
                        </div>
                        <div class="stat-val">{{ $stats['templates'] }}</div>
                        <div class="stat-txt">Templates</div>
                    </div>
                    <div class="stat-item" data-animate="fade-up" style="animation-delay: 0.2s">
                        <div class="stat-icon-wrapper" style="background-color: #22c55e;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="stat-val">{{ $stats['certificates'] }}</div>
                        <div class="stat-txt">Certificates</div>
                    </div>
                    <div class="stat-item" data-animate="fade-up" style="animation-delay: 0.3s">
                        <div class="stat-icon-wrapper" style="background-color: #f97316;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="stat-val">{{ $stats['avgDays'] }}</div>
                        <div class="stat-txt">Avg Days Open</div>
                    </div>
                </div>

                <div class="doc-controls">
                    <div class="doc-search-wrapper">
                        <svg class="doc-search-icon" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" class="doc-search-input"
                            placeholder="Search by quotation # or customer...">
                    </div>
                    <select class="doc-status-filter">
                        <option value="all">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="won">Won</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>

                <div class="doc-table">
                    <div class="table-head">
                        <div class="th">Quotation ID</div>
                        <div class="th">Customer</div>
                        <div class="th">Product</div>
                        <div class="th">Amount</div>
                        <div class="th">Version</div>
                        <div class="th">Status</div>
                        <div class="th">Actions</div>
                    </div>

                    <div class="table-body">
                        @forelse($quotations as $row)
                            @php
                                $firstProduct = $row->lineItems->first()?->product?->Product_Name ?? 'No Product';
                                if ($row->lineItems->count() > 1) {
                                    $firstProduct =
                                        ($row->lineItems->first()?->product?->Product_Name ?? 'No Product') . ' ...';
                                }
                            @endphp
                            <div class="table-row" data-status="{{ strtolower($row->Status) }}">
                                <div class="td quote-id">{{ $row->Quotation_Number }}</div>
                                <div class="td">{{ $row->customer->Institution_Name ?? 'N/A' }}</div>
                                <div class="td" style="color: #64748b;">{{ $firstProduct }}</div>
                                <div class="td" style="font-weight: 700;">
                                    ₱{{ number_format($row->Total_Amount_PHP, 0) }}</div>
                                <div class="td">
                                    <span class="version-badge">v{{ $row->Version_Number }}</span>
                                </div>
                                <div class="td">
                                    <span
                                        class="status-pill status-{{ strtolower($row->Status) }}">{{ $row->Status }}</span>
                                </div>
                                <div class="td">
                                    <div class="action-links">
                                        <svg class="icon-action view-quote-btn" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" data-quote-id="{{ $row->Quotation_ID }}"
                                            title="View Details">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        @if (!in_array($row->Status, ['Won', 'Lost']))
                                            <span class="action-link"
                                                onclick="openReviseModal({{ $row->Quotation_ID }})">Revise</span>
                                        @endif
                                        <span class="action-link"
                                            onclick="openStatusModal({{ $row->Quotation_ID }}, '{{ $row->Status }}')">Status</span>
                                        <svg class="icon-action" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            onclick="window.location.href='{{ route('admin.documents.download', $row->Quotation_ID) }}'"
                                            title="Download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" y1="15" x2="12" y2="3" />
                                        </svg>
                                        <svg class="icon-action" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            onclick="openVersionHistoryModal({{ $row->Quotation_ID }})"
                                            title="History">
                                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                            <path d="M3 3v5h5" />
                                            <path d="M12 7v5l4 2" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="table-row"
                                style="grid-template-columns: 1fr; text-align: center; padding: 3rem;">
                                <div class="td" style="color: var(--fin-gray);">No quotations found. Start by
                                    creating one.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="doc-footer-grid">
                <div class="footer-section" data-animate="fade-in">
                    <div class="footer-header">
                        <h3 class="footer-title">Supporting Documents</h3>
                    </div>
                    <div class="file-list">
                        @forelse($documents as $doc)
                            <div class="file-item" data-doc-id="{{ $doc->Document_ID }}">
                                <div class="file-info">
                                    <div class="file-icon-box">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="#22c55e" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                            </path>
                                            <polyline points="14.5 2 14.5 8 20 8"></polyline>
                                        </svg>
                                    </div>
                                    <div class="file-details">
                                        <div class="file-name">{{ $doc->File_Name }}</div>
                                        <div class="file-meta">{{ $doc->Document_Type }} •
                                            {{ round($doc->File_Size / 1024 / 1024, 1) }}
                                            MB{{ $doc->Related_Entity_Type ? ' • Linked to: ' . $doc->Related_Entity_Type : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="file-actions">
                                    <svg class="icon-action" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        onclick="window.location.href='{{ route('admin.documents.download', $doc->Document_ID) }}'"
                                        title="Download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    <svg class="icon-action doc-delete-btn" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        data-doc-id="{{ $doc->Document_ID }}" data-doc-name="{{ $doc->File_Name }}"
                                        title="Delete">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--fin-gray); text-align: center; padding: 1rem;">No files uploaded.
                            </p>
                        @endforelse
                    </div>
                </div>

                <div class="footer-section" data-animate="fade-in">
                    <div class="footer-header">
                        <h3 class="footer-title" style="margin: 0;">Quotation Templates</h3>
                        <button class="plus-btn" onclick="openTemplatesModal()">+</button>
                    </div>
                    <div class="template-list">
                        @forelse($templates as $tpl)
                            <div class="template-item" onclick="openTemplatesModal({{ $tpl->Template_ID }})"
                                style="cursor: pointer;">
                                <div class="template-info">
                                    <div class="template-name">{{ $tpl->Template_Name }}</div>
                                    <div class="template-meta">{{ $tpl->Template_Type }}</div>
                                </div>
                                <svg class="icon-action" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="opacity: 0.5;">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </div>
                        @empty
                            <p style="color: var(--fin-gray); text-align: center; padding: 1rem; font-size: 0.85rem;">
                                No templates yet. Click + to create one.</p>
                        @endforelse
                    </div>
                </div>
            </div>
    </main>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function createModal(title, bodyHTML, footerHTML) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.setAttribute('aria-hidden', 'false');
        overlay.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${title}</h3>
                    <button class="close-modal close-modal-x">&times;</button>
                </div>
                <div class="modal-body">${bodyHTML}</div>
                <div class="modal-footer">${footerHTML}</div>
            </div>
        `;
        document.body.appendChild(overlay);

        requestAnimationFrame(() => {
            overlay.classList.add('modal-opening');
        });

        overlay.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => closeModal(overlay));
        });
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay);
        });

        return overlay;
    }

    function closeModal(overlay) {
        overlay.classList.remove('modal-opening');
        overlay.classList.add('modal-closing');
        setTimeout(() => {
            overlay.setAttribute('aria-hidden', 'true');
            overlay.remove();
        }, 350);
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function openUploadModal() {
        const body = `
            <form id="uploadForm" class="high-fidelity-form">
                <div class="form-group">
                    <label>Document Name</label>
                    <input type="text" name="document_name" class="form-control" placeholder="e.g., FDA Certificate - Ultrasound" required>
                </div>
                
                <div class="form-group">
                    <label>Document Type</label>
                    <select name="document_type" class="form-control" required>
                        <option value="" disabled selected>Select Document type...</option>
                        <option value="Certificate">Certificate</option>
                        <option value="TechnicalSpec">Technical Spec</option>
                        <option value="Contract">Contract</option>
                        <option value="Quote">Signed Quote</option>
                        <option value="Identity">Identity Document</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Link to Product/Customer</label>
                    <div class="dynamic-link-row">
                        <select id="relatedTypeSelector" name="related_type" class="form-control type-select">
                            <option value="">General</option>
                            <option value="Customer">Customer</option>
                            <option value="Quotation">Quotation</option>
                            <option value="Product">Product</option>
                            <option value="Sale">Sale (Invoice)</option>
                        </select>
                        <select id="relatedIdSelector" name="related_id" class="form-control id-select">
                            <option value="">N/A</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload File</label>
                    <input type="file" name="file" class="form-control file-input" required>
                    <small class="form-hint">Accepted: PDF, JPG, PNG, DOC, DOCX (Max 10MB)</small>
                </div>

                <div class="form-group">
                    <label>Expiry Date (Optional)</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>

                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="additional_notes" class="form-control" placeholder="Optional notes about this document..." rows="3"></textarea>
                </div>
            </form>
        `;
        const footer = `
            <button class="btn btn-outline close-modal">Cancel</button>
            <button class="btn btn-primary btn-solid-teal" onclick="submitUpload(this)">Upload Document</button>
        `;
        const modal = createModal('Manage Supporting Documents', body, footer);

        const typeSelect = modal.querySelector('#relatedTypeSelector');
        const idSelect = modal.querySelector('#relatedIdSelector');

        typeSelect.addEventListener('change', () => {
            const type = typeSelect.value;
            idSelect.innerHTML = '<option value="">Loading...</option>';

            if (!type) {
                idSelect.innerHTML = '<option value="">N/A</option>';
                return;
            }

            // Client-side populate from already available data
            if (type === 'Customer') {
                idSelect.innerHTML = `<option value="">Select Customer...</option>
                    @foreach ($customers as $c)
                        <option value="{{ $c->Customer_ID }}">{{ $c->Institution_Name }}</option>
                    @endforeach`;
            } else if (type === 'Quotation') {
                idSelect.innerHTML = `<option value="">Select Quotation...</option>
                    @foreach ($quotations as $q)
                        <option value="{{ $q->Quotation_ID }}">{{ $q->Quotation_Number }}</option>
                    @endforeach`;
            } else if (type === 'Product') {
                idSelect.innerHTML = `<option value="">Select Product...</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->Product_ID }}">{{ $p->Product_Name }}</option>
                    @endforeach`;
            } else if (type === 'Sale') {
                const sales = @json($sales);
                idSelect.innerHTML = `<option value="">Select Invoice...</option>`;
                sales.forEach(s => {
                    idSelect.innerHTML +=
                        `<option value="${s.Sale_ID}">INV-${String(s.Sale_ID).padStart(4, '0')} (${s.customer?.Institution_Name || 'N/A'})</option>`;
                });
            } else {
                idSelect.innerHTML = '<option value="">Select Record...</option>';
            }
        });
    }

    async function submitUpload(btn) {
        const modal = btn.closest('.modal-overlay');
        const form = modal.querySelector('#uploadForm');
        const formData = new FormData(form);

        btn.disabled = true;
        btn.innerText = 'Uploading...';

        try {
            const response = await fetch('{{ route('admin.documents.upload') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                showToast('Document uploaded successfully');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(result.message || 'Upload failed', 'error');
                btn.disabled = false;
                btn.innerText = 'Upload Document';
            }
        } catch (error) {
            showToast('Connection error', 'error');
            btn.disabled = false;
            btn.innerText = 'Upload Document';
        }
    }

    function openNewQuotationModal() {
        const body = `
            <form id="newQuotationForm" class="high-fidelity-form">
                <div class="form-group">
                    <label>Select Template</label>
                    <select name="template_id" class="form-control">
                        <option value="">Select Template...</option>
                        @foreach ($templates as $t)
                            <option value="{{ $t->Template_ID }}">{{ $t->Template_Name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Customer Name</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="" disabled selected>Enter customer name...</option>
                        @foreach ($customers as $c)
                            <option value="{{ $c->Customer_ID }}">{{ $c->Institution_Name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Product/Service</label>
                    <select id="quoteProductSelect" name="product_id" class="form-control" required onchange="updateQuoteUnitPrice(this)">
                        <option value="" disabled selected>Select Product...</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->Product_ID }}" data-price="{{ $p->Unit_Price_USD }}">{{ $p->Product_Name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="dynamic-link-row">
                    <div class="form-group" style="flex: 1;">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Unit Price (₱)</label>
                        <input type="number" id="quoteUnitPrice" name="price" class="form-control" placeholder="0.00" step="0.01" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="additional_notes" class="form-control" placeholder="Optional notes or terms..." rows="3"></textarea>
                </div>
                
                <!-- Hidden fields for the existing controller logic -->
                <input type="hidden" name="title" id="quoteTitleHidden" value="">
                <input type="hidden" name="status" value="Draft">
                <input type="hidden" name="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
            </form>
        `;
        const footer = `
            <button class="btn btn-outline close-modal">Cancel</button>
            <button class="btn btn-primary btn-solid-teal" onclick="submitNewQuotation(this)">Generate Quotation</button>
        `;
        const modal = createModal('Generate New Quotation', body, footer);

        // Dynamic title update based on product
        const productSelect = modal.querySelector('#quoteProductSelect');
        productSelect.addEventListener('change', () => {
            const productText = productSelect.options[productSelect.selectedIndex].text;
            modal.querySelector('#quoteTitleHidden').value = 'Quotation for ' + productText;
        });
    }

    function updateQuoteUnitPrice(select) {
        const price = select.options[select.selectedIndex].getAttribute('data-price');
        // Convert USD to PHP approximately for display if needed, but the image shows ₱
        // We'll use the price directly as it might be stored in PHP or USD
        document.getElementById('quoteUnitPrice').value = price;
    }

    async function submitNewQuotation(btn) {
        const modal = btn.closest('.modal-overlay');
        const form = modal.querySelector('#newQuotationForm');

        const customerSelect = form.querySelector('[name="customer_id"]');
        const productSelect = form.querySelector('[name="product_id"]');
        const quantityInput = form.querySelector('[name="quantity"]');
        const priceInput = form.querySelector('[name="price"]');

        // Clear previous errors
        [customerSelect, productSelect, quantityInput, priceInput].forEach(el => el.classList.remove(
            'error-border'));

        if (!customerSelect.value) {
            showToast('Customer is required.', 'error');
            customerSelect.classList.add('error-border');
            customerSelect.focus();
            return;
        }
        if (!productSelect.value) {
            showToast('Please select a product.', 'error');
            productSelect.classList.add('error-border');
            productSelect.focus();
            return;
        }
        if (!quantityInput.value || quantityInput.value <= 0) {
            showToast('Please enter a valid quantity.', 'error');
            quantityInput.classList.add('error-border');
            quantityInput.focus();
            return;
        }
        if (!priceInput.value || priceInput.value <= 0) {
            showToast('Please enter a valid price.', 'error');
            priceInput.classList.add('error-border');
            priceInput.focus();
            return;
        }

        const payload = {
            customer_id: customerSelect.value,
            title: form.querySelector('#quoteTitleHidden').value || 'New Quotation',
            template_id: form.querySelector('[name="template_id"]').value,
            additional_notes: form.querySelector('[name="additional_notes"]').value,
            valid_until: form.querySelector('[name="valid_until"]').value,
            status: 'Draft',
            total_amount: priceInput.value * quantityInput.value, // This is expected in validation
            items: [{
                product_id: productSelect.value,
                quantity: quantityInput.value,
                price: priceInput.value
            }]
        };

        btn.disabled = true;
        btn.innerText = 'Generating...';

        try {
            const response = await fetch('{{ route('admin.customers.quotation') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const result = await response.json();
            if (result.success) {
                showToast('Quotation generated successfully');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(result.message || 'Generation failed', 'error');
                btn.disabled = false;
                btn.innerText = 'Generate Quotation';
            }
        } catch (error) {
            showToast('Connection error', 'error');
            btn.disabled = false;
            btn.innerText = 'Generate Quotation';
        }
    }

    function openReviseModal(quotationId) {
        // Find existing quotation data for pre-filling
        const quotations = @json($quotations);
        const quote = quotations.find(q => q.Quotation_ID == quotationId);

        const currentQty = quote?.line_items?.[0]?.Quantity || 1;
        const currentPrice = quote?.line_items?.[0]?.Unit_Price || 0;

        const body = `
            <form id="reviseQuotationForm" class="high-fidelity-form">
                <input type="hidden" name="id" value="${quotationId}">
                
                <div class="form-group">
                    <label>Select Quotation</label>
                    <select name="selected_id" class="form-control" disabled>
                        <option value="${quotationId}" selected>${quote?.Quotation_Number || 'QT-XXXX'}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Quotation Title</label>
                    <input type="text" name="title" class="form-control" value="${quote?.Title || ''}" required>
                </div>

                <div class="form-group">
                    <label>Expiration Date</label>
                    <input type="date" name="expiration_date" class="form-control" value="${quote?.Expiration_Date ? quote.Expiration_Date.split('T')[0] : ''}" required>
                </div>

                <div class="form-group">
                    <label>Type of Changes</label>
                    <input type="text" name="change_type" class="form-control" placeholder="e.g., Price adjustments, Quantity update">
                </div>

                <div class="form-group">
                    <label>New Unit Price (₱) (Optional)</label>
                    <input type="number" name="new_unit_price" class="form-control" placeholder="${currentPrice}" step="0.01">
                </div>

                <div class="form-group">
                    <label>New Quantity (Optional)</label>
                    <input type="number" name="new_quantity" class="form-control" placeholder="${currentQty}" min="1">
                </div>

                <div class="form-group">
                    <label>Revision Notes</label>
                    <textarea name="revision_notes" class="form-control" placeholder="Describe the changes made..." rows="3"></textarea>
                </div>

                <div class="modal-notice">
                    <p>Previous version will be archived with complete history. New version number will be auto-generated.</p>
                </div>
            </form>
        `;
        const footer = `
            <button class="btn btn-outline close-modal">Cancel</button>
            <button class="btn btn-primary btn-solid-teal" onclick="submitRevision(this)">Save Revision</button>
        `;
        createModal('Revise Quotation', body, footer);
    }

    async function submitRevision(btn) {
        const modal = btn.closest('.modal-overlay');
        const form = modal.querySelector('#reviseQuotationForm');
        const id = form.querySelector('[name="id"]').value;
        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        btn.disabled = true;
        btn.innerText = 'Archiving & Saving...';

        try {
            const response = await fetch(`/admin/quotations/${id}/revise`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const result = await response.json();
            if (result.success) {
                showToast('New revision created: v' + result.quotation.Version_Number);
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(result.message || 'Revision failed', 'error');
                btn.disabled = false;
                btn.innerText = 'Save Revision';
            }
        } catch (error) {
            showToast('Network error', 'error');
            btn.disabled = false;
            btn.innerText = 'Save Revision';
        }
    }

    function openStatusModal(id, currentStatus) {
        // Find existing quotation data for pre-filling
        const quotations = @json($quotations);
        const quote = quotations.find(q => q.Quotation_ID == id);

        const statuses = ['Draft', 'Sent', 'Pending', 'Approved', 'Won', 'Lost'];
        let options = '';
        statuses.forEach(s => {
            options += `<option value="${s}" ${s === currentStatus ? 'selected' : ''}>${s}</option>`;
        });

        const body = `
            <form id="statusUpdateForm" class="high-fidelity-form">
                <input type="hidden" name="id" value="${id}">
                
                <div class="form-group">
                    <label>Select Quotation</label>
                    <select class="form-control" disabled>
                        <option selected>${quote?.Quotation_Number || 'QT-XXXX'}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Update Status</label>
                    <select name="status" class="form-control" required>
                        <option value="" disabled>Select new Status...</option>
                        ${options}
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Notes</label>
                    <textarea name="status_notes" class="form-control" placeholder="Add notes about this status update..." rows="3">${quote?.Status_Notes || ''}</textarea>
                </div>

                <div class="modal-notice-teal">
                    <p>Status updates are tracked with timestamps and will appear in the quotation history.</p>
                </div>
            </form>
        `;
        const footer = `
            <button class="btn btn-outline close-modal">Cancel</button>
            <button class="btn btn-primary btn-solid-teal" onclick="updateStatus(this)">Update Status</button>
        `;
        createModal('Track Quotation Status', body, footer);
    }

    async function updateStatus(btn) {
        const modal = btn.closest('.modal-overlay');
        const form = modal.querySelector('#statusUpdateForm');
        const id = form.querySelector('[name="id"]').value;
        const status = form.querySelector('[name="status"]').value;
        const notes = form.querySelector('[name="status_notes"]').value;

        btn.disabled = true;
        btn.innerText = 'Updating...';

        try {
            const response = await fetch(`/admin/quotations/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    status_notes: notes
                })
            });
            const result = await response.json();
            if (result.success) {
                showToast('Status updated to ' + result.status);
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(result.message || 'Update failed', 'error');
                btn.disabled = false;
                btn.innerText = 'Update Status';
            }
        } catch (error) {
            showToast('Update failed', 'error');
            btn.disabled = false;
            btn.innerText = 'Update Status';
        }
    }

    function openVersionHistoryModal(id) {
        const quotations = @json($quotations);
        const selectedQuote = quotations.find(q => q.Quotation_ID == id);
        if (!selectedQuote) return;

        // Find all versions by comparing the base Quotation_Number (without suffix)
        const baseNumber = selectedQuote.Quotation_Number.replace(/-V\d+$/, '');
        const versions = quotations
            .filter(q => {
                const qBase = q.Quotation_Number.replace(/-V\d+$/, '');
                return qBase === baseNumber;
            })
            .sort((a, b) => b.Version_Number - a.Version_Number);

        let body = `<div class="version-list">`;

        versions.forEach(v => {
            const isCurrent = v.Quotation_ID === selectedQuote.Quotation_ID;
            const modifiedDate = new Date(v.updated_at).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            const modifiedTime = new Date(v.updated_at).toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit'
            });
            const creator = v.creator ? v.creator.name : 'System';
            const amount = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(v.Total_Amount_PHP);

            // Extract change type from Additional_Notes if available
            let changes = v.Additional_Notes || 'Initial quotation created';
            if (changes.includes('Change Type:')) {
                changes = changes.split('\n')[0].replace('Change Type:', '').trim();
            }

            body += `
                <div class="version-card ${isCurrent ? 'is-current' : ''}">
                    <div class="version-header">
                        <div class="version-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="version-info">
                            <div class="version-number">
                                v${v.Version_Number}
                                ${isCurrent ? '<span class="version-badge">Current</span>' : ''}
                            </div>
                            <div class="version-meta">Modified by ${creator} on ${modifiedDate} at ${modifiedTime}</div>
                        </div>
                    </div>
                    <div class="version-changes">
                        <strong>Changes:</strong> ${changes}
                    </div>
                    <div class="version-amount">
                        Amount: ${amount}
                    </div>
                    <div class="version-download" onclick="window.location.href='/admin/documents/download/${v.Quotation_ID}'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </div>
                </div>
            `;
        });

        body += `</div>`;

        const footer = `
            <div style="flex: 1; color: #64748b; font-size: 0.9rem;">${versions.length} versions total</div>
            <button class="btn btn-primary btn-solid-teal close-modal">Close</button>
        `;

        const header = `
            <div style="display: flex; flex-direction: column;">
                <span>Quotation Version History</span>
                <span style="font-size: 0.9rem; font-weight: 400; color: #64748b; margin-top: 4px;">${selectedQuote.Quotation_Number}</span>
            </div>
        `;

        createModal(header, body, footer);
    }

    function openTemplatesModal(templateId = null) {
        const templates = @json($templates);
        let template = null;
        if (templateId) {
            template = templates.find(t => t.Template_ID == templateId);
        }

        let body = `
            <div class="template-management-container">
                <div class="template-list-section" style="margin-bottom: 24px; max-height: 200px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px;">
                    <h4 style="font-size: 0.9rem; font-weight: 600; color: #64748b; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <span>Existing Templates</span>
                        <button class="btn btn-outline" style="padding: 4px 8px; font-size: 0.75rem;" onclick="openTemplatesModal()">+ New</button>
                    </h4>
                    <div class="template-items">
        `;

        if (templates.length === 0) {
            body +=
                `<p style="font-size: 0.85rem; color: #94a3b8; text-align: center; padding: 12px;">No templates found.</p>`;
        } else {
            templates.forEach(t => {
                body += `
                    <div class="template-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; border-bottom: 1px solid #f1f5f9; cursor: pointer;" onclick="openTemplatesModal(${t.Template_ID})">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.9rem; font-weight: 500; color: #1e293b;">${t.Template_Name}</span>
                            <span style="font-size: 0.75rem; color: #64748b;">${t.Template_Type}</span>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <svg class="icon-action" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="event.stopPropagation(); deleteTemplate(${t.Template_ID})"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </div>
                    </div>
                `;
            });
        }

        body += `
                    </div>
                </div>

                <form id="templateForm" class="high-fidelity-form">
                    <input type="hidden" name="template_id" value="${template?.Template_ID || ''}">
                    
                    <div class="form-group">
                        <label>Template Name</label>
                        <input type="text" name="template_name" class="form-control" placeholder="e.g., Standard Hospital Quotation" required value="${template?.Template_Name || ''}">
                    </div>

                    <div class="form-group">
                        <label>Customer Segment</label>
                        <select name="template_type" class="form-control" required>
                            <option value="Standard" ${template?.Template_Type === 'Standard' ? 'selected' : ''}>Standard</option>
                            <option value="Hospital" ${template?.Template_Type === 'Hospital' ? 'selected' : ''}>Hospital</option>
                            <option value="Government" ${template?.Template_Type === 'Government' ? 'selected' : ''}>Government</option>
                            <option value="PrivateInstitution" ${template?.Template_Type === 'PrivateInstitution' ? 'selected' : ''}>Private Institution</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Header Text</label>
                        <textarea name="header_text" class="form-control" placeholder="Enter header text to appear at the top of quotation..." rows="3">${template?.Header_Text || ''}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Footer Text</label>
                        <textarea name="footer_text" class="form-control" placeholder="Enter footer text (contact info, thank you message, etc.)..." rows="3">${template?.Footer_Text || ''}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Terms & Conditions</label>
                        <textarea name="terms_conditions" class="form-control" placeholder="Enter standard terms and conditions..." rows="3">${template?.Terms_Conditions || ''}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Branding Color</label>
                        <div class="color-row">
                            <input type="color" id="brandingColorPicker" class="color-preview" value="${template?.Branding_Color || '#14b8a6'}" oninput="document.getElementById('brandingColorHex').value = this.value.toUpperCase()">
                            <input type="text" name="branding_color" id="brandingColorHex" class="form-control" value="${template?.Branding_Color || '#14B8A6'}" placeholder="#FFFFFF" maxlength="7" oninput="document.getElementById('brandingColorPicker').value = this.value">
                        </div>
                        <p class="form-help-text">Choose primary color for this template</p>
                    </div>
                </form>
            </div>
        `;

        const footer = `
            <button class="btn btn-outline close-modal">Cancel</button>
            <button class="btn btn-primary btn-solid-teal" onclick="saveTemplate(this)">${templateId ? 'Update' : 'Save'} Template</button>
        `;

        createModal(templateId ? 'Edit Quotation Template' : 'Create Quotation Template', body, footer);
    }

    async function saveTemplate(btn) {
        const modal = btn.closest('.modal-overlay');
        const form = modal.querySelector('#templateForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        btn.disabled = true;
        btn.innerText = 'Saving...';

        try {
            const response = await fetch('/admin/quotation-templates/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                showToast(result.message || 'Template saved successfully');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(result.message || 'Failed to save', 'error');
                btn.disabled = false;
                btn.innerText = 'Save Template';
            }
        } catch (error) {
            showToast('Save failed', 'error');
            btn.disabled = false;
            btn.innerText = 'Save Template';
        }
    }

    async function deleteTemplate(id) {
        if (!confirm('Are you sure you want to delete this template?')) return;

        try {
            const response = await fetch(`/admin/quotation-templates/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (result.success) {
                showToast('Template deleted');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(result.message || 'Delete failed', 'error');
            }
        } catch (error) {
            showToast('Delete failed', 'error');
        }
    }
    // ── Search & Filter ──
    const searchInput = document.querySelector('.doc-search-input');
    const statusFilter = document.querySelector('.doc-status-filter');

    function filterQuotations() {
        const query = (searchInput?.value || '').toLowerCase();
        const status = statusFilter?.value || 'all';
        document.querySelectorAll('.table-body .table-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowStatus = row.getAttribute('data-status') || '';
            const matchesSearch = !query || text.includes(query);
            const matchesStatus = status === 'all' || rowStatus === status;
            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    searchInput?.addEventListener('input', filterQuotations);
    statusFilter?.addEventListener('change', filterQuotations);

    // ── View Quotation Detail Modal ──
    document.querySelectorAll('.view-quote-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-quote-id');
            const quotations = @json($quotations);
            const quote = quotations.find(q => q.Quotation_ID == id);
            if (!quote) return;

            const customer = quote.customer?.Institution_Name || 'N/A';
            const amount = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(quote.Total_Amount_PHP);
            const created = new Date(quote.created_at).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            const expires = quote.Expiration_Date ? new Date(quote.Expiration_Date).toLocaleDateString(
                'en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                }) : 'N/A';

            let itemsHtml = '<div style="margin-top: 0.5rem;">';
            if (quote.line_items && quote.line_items.length > 0) {
                quote.line_items.forEach((item, i) => {
                    const productName = item.product?.Product_Name || 'Unknown Product';
                    const lineTotal = new Intl.NumberFormat('en-PH', {
                        style: 'currency',
                        currency: 'PHP'
                    }).format(item.Line_Total || (item.Unit_Price * item.Quantity));
                    itemsHtml += `<div style="padding: 0.5rem 0; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between;">
                        <span>${i + 1}. ${productName} × ${item.Quantity}</span>
                        <span style="font-weight: 600;">${lineTotal}</span>
                    </div>`;
                });
            } else {
                itemsHtml += '<p style="color: #94a3b8; font-size: 0.85rem;">No line items</p>';
            }
            itemsHtml += '</div>';

            const body = `
                <div class="high-fidelity-form" style="gap: 0.75rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <div class="form-group"><label>Quotation #</label><div style="font-weight: 600; color: var(--fin-teal);">${quote.Quotation_Number}</div></div>
                        <div class="form-group"><label>Status</label><div><span class="status-pill status-${quote.Status.toLowerCase()}">${quote.Status}</span></div></div>
                        <div class="form-group"><label>Customer</label><div style="font-weight: 500;">${customer}</div></div>
                        <div class="form-group"><label>Version</label><div>v${quote.Version_Number}</div></div>
                        <div class="form-group"><label>Created</label><div>${created}</div></div>
                        <div class="form-group"><label>Expires</label><div>${expires}</div></div>
                    </div>
                    <div class="form-group"><label>Total Amount</label><div style="font-size: 1.25rem; font-weight: 700; color: var(--fin-teal);">${amount}</div></div>
                    <div class="form-group"><label>Line Items</label>${itemsHtml}</div>
                    ${quote.Additional_Notes ? `<div class="form-group"><label>Notes</label><div style="font-size: 0.85rem; color: #64748b;">${quote.Additional_Notes}</div></div>` : ''}
                </div>
            `;
            const footer = `<button class="btn btn-primary btn-solid-teal close-modal">Close</button>`;
            createModal('Quotation Details', body, footer);
        });
    });

    // ── Delete Supporting Document ──
    document.querySelectorAll('.doc-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.getAttribute('data-doc-id');
            const name = this.getAttribute('data-doc-name');

            const body =
                `<p style="color: var(--fin-slate); font-size: 0.95rem;">Are you sure you want to delete <strong>${name}</strong>?</p>
                <div class="modal-notice"><p>This action will permanently remove the document. This cannot be undone.</p></div>`;
            const footer = `
                <button class="btn btn-outline close-modal">Cancel</button>
                <button class="btn btn-solid-teal" style="background: #ef4444 !important;" onclick="confirmDeleteDoc(this, ${id})">Delete Document</button>
            `;
            createModal('Delete Document', body, footer);
        });
    });

    async function confirmDeleteDoc(btn, id) {
        btn.disabled = true;
        btn.innerText = 'Deleting...';
        try {
            const response = await fetch(`/admin/documents/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (result.success) {
                showToast('Document deleted successfully');
                const item = document.querySelector(`.file-item[data-doc-id="${id}"]`);
                if (item) {
                    item.style.transition = 'opacity 0.3s';
                    item.style.opacity = '0';
                    setTimeout(() => item.remove(), 300);
                }
                closeModal(btn.closest('.modal-overlay'));
            } else {
                showToast(result.message || 'Delete failed', 'error');
                btn.disabled = false;
                btn.innerText = 'Delete Document';
            }
        } catch (error) {
            showToast('Delete failed', 'error');
            btn.disabled = false;
            btn.innerText = 'Delete Document';
        }
    }
</script>
