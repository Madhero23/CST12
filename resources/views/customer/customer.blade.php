@vite(['resources/css/customer.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">CM</h1>
        </div>

        <div class="admin-crm">
            <div class="crm-unified-card">
                <!-- Unified Header: Title + Actions -->
                <div class="crm-header-row">
                    <div class="crm-title-section">
                        <span class="customer-mgmt-label">Customer Management</span>
                    </div>
                    
                    <div class="crm-actions">
                        <button class="action-btn reminders-btn">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8.5V11a1 1 0 0 1-2 0v-2.5a4 4 0 0 0-8 0v2.5a1 1 0 0 1-2 0V8.5a6 6 0 0 1 12 0zM12 2v1M5 19h14M10 19v1a2 2 0 0 0 4 0v-1"></path>
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span>Reminders</span>
                        </button>
                        <button class="action-btn quote-btn">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                            <span>Create Quote</span>
                        </button>
                        <button class="action-btn primary-btn add-customer-btn">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            <span>Add Customer</span>
                        </button>
                    </div>
                </div>
                
                <!-- Quote Pipeline -->
                <div class="quote-pipeline-section">
                    <h3 class="section-subtitle">Quote Pipeline</h3>
                    <div class="pipeline-stats">
                        @php
                            $pipelineDisplay = [
                                ['count' => $pipelineStats['draft'] ?? 0, 'label' => 'Draft'],
                                ['count' => $pipelineStats['pending'] ?? 0, 'label' => 'Pending'],
                                ['count' => $pipelineStats['sent'] ?? 0, 'label' => 'Sent'],
                                ['count' => $pipelineStats['follow_up'] ?? 0, 'label' => 'Follow-Up'],
                                ['count' => $pipelineStats['won'] ?? 0, 'label' => 'Won'],
                            ];
                        @endphp
                        
                        @foreach($pipelineDisplay as $index => $stat)
                        <div class="stat-card" data-animation-delay="{{ $index * 0.1 }}">
                            <div class="stat-count">{{ $stat['count'] }}</div>
                            <div class="stat-label">{{ $stat['label'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Customer Table -->
                <div class="customer-table-container">
                    <table class="customer-table">
                        <thead>
                            <tr>
                                <th class="table-header">Name</th>
                                <th class="table-header">Email</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Last Interaction</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $customer)
                            <tr class="customer-row" data-animation-delay="{{ $index * 0.1 }}" data-customer-id="{{ $customer->Customer_ID }}" data-json="{{ json_encode($customer) }}">
                                <td class="customer-cell">
                                    <div class="customer-name">{{ $customer->Institution_Name ?? $customer->Contact_Person ?? 'N/A' }}</div>
                                </td>
                                <td class="customer-cell">
                                    <div class="customer-email">{{ $customer->Email ?? 'N/A' }}</div>
                                </td>
                                <td class="customer-cell">
                                    <span class="status-badge {{ strtolower($customer->Status ?? 'active') }}">
                                        {{ $customer->Status ?? 'Active' }}
                                    </span>
                                </td>
                                <td class="customer-cell">
                                    <div class="last-interaction">{{ $customer->updated_at ? $customer->updated_at->diffForHumans() : 'N/A' }}</div>
                                </td>
                                <td class="customer-cell">
                                    <div class="customer-actions">
                                        <button class="icon-btn view-btn" title="View/Edit Customer">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <span>View</span>
                                        </button>
                                        <button class="icon-btn logs-btn" title="View Logs">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <path d="M16 13H8M16 17H8M10 9H8"></path>
                                            </svg>
                                            <span>Logs</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="customer-cell" style="text-align: center; padding: 2rem;">
                                    No customers found. Click "Add Customer" to create one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>




<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const products = @json($products ?? []);

    // ========== MODAL SYSTEM ==========

    function createModal(title, bodyHTML, footerHTML) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${title}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">${bodyHTML}</div>
                <div class="modal-footer">${footerHTML}</div>
            </div>
        `;
        document.body.appendChild(overlay);
        requestAnimationFrame(() => overlay.classList.add('show'));

        // Close handlers
        overlay.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => closeModal(overlay));
        });
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay);
        });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') {
                closeModal(overlay);
                document.removeEventListener('keydown', handler);
            }
        });

        return overlay;
    }

    function closeModal(overlay) {
        overlay.classList.remove('show');
        setTimeout(() => overlay.remove(), 300);
    }

    function showToast(message, type = 'success') {
        const existing = document.querySelector('.crm-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = `crm-toast toast-${type}`;
        toast.innerHTML = `<span>${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ========== VIEW CUSTOMER MODAL ==========
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('.customer-row');
            const custData = JSON.parse(row.dataset.json || '{}');
            
            const name = custData.Institution_Name || 'N/A';
            const contact = custData.Contact_Person || 'N/A';
            const email = custData.Email || 'N/A';
            const phone = custData.Phone || 'N/A';
            const address = custData.Address || 'N/A';
            const status = custData.Status || 'Active';
            const type = custData.Customer_Type || 'N/A';
            const priority = custData.Segment_Type || 'N/A';

            const body = `
                <div class="view-customer-details">
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Institution</label>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">${name}</div>
                        </div>
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Contact Person</label>
                            <div style="font-size: 16px; font-weight: 500; color: #374151;">${contact}</div>
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Email</label>
                            <div style="font-size: 15px; color: #374151;">${email}</div>
                        </div>
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Phone</label>
                            <div style="font-size: 15px; color: #374151;">${phone}</div>
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Type</label>
                            <div style="font-size: 15px; color: #374151;">${type}</div>
                        </div>
                        <div>
                            <label class="form-label" style="color: #6b7280; font-size: 13px;">Priority</label>
                            <div style="font-size: 15px; color: #374151;">${priority}</div>
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label class="form-label" style="color: #6b7280; font-size: 13px;">Address</label>
                        <div style="font-size: 15px; color: #374151; line-height: 1.5;">${address}</div>
                    </div>

                    <div>
                        <label class="form-label" style="color: #6b7280; font-size: 13px;">Current Status</label>
                        <span class="status-badge ${status.toLowerCase()}" style="display: inline-block; margin-top: 4px;">${status}</span>
                    </div>
                </div>
            `;

            const footer = `
                <button class="modal-btn secondary close-modal">Close</button>
                <button class="modal-btn secondary create-quote-btn" style="margin-right: 8px;">Create Quote</button>
                <button class="modal-btn primary edit-from-view-btn">Edit Customer</button>
            `;

            const modal = createModal('Customer Profile', body, footer);

            // Styling overrides
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.style.border = '1px solid #e2f1f1';
                content.style.maxWidth = '600px';
            }
            const title = modal.querySelector('.modal-header h3');
            if (title) {
                title.style.fontSize = '28px'; // Slightly smaller than Add/Edit
                title.style.fontWeight = '700';
                title.style.color = '#235c63';
            }

            // Edit handler from View modal
            modal.querySelector('.edit-from-view-btn').addEventListener('click', () => {
                closeModal(modal);
                // Wait for close animation then open edit
                setTimeout(() => openEditCustomerModal(row.dataset.customerId), 300);
            });

            // Create Quote handler from View modal
            modal.querySelector('.create-quote-btn').addEventListener('click', () => {
                closeModal(modal);
                setTimeout(() => openCreateQuoteModal(row.dataset.customerId, name), 300);
            });
        });
    });

    // ========== EDIT CUSTOMER MODAL ==========
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (!btn) return;

        e.preventDefault();
        const row = btn.closest('.customer-row');
        const id = row.dataset.customerId;
        
        // Fetch current data from row or data attributes (assuming we might need to fetch full details if not all are in row)
        // For now, we will scrape what we can and use placeholders for what's missing, OR we could fetch. 
        // Given the requirement for high fidelity, let's try to get data from the row if present, or fallback.
        // ideally we should fetch fresh data, but let's stick to the pattern.
        // actually, to get Address/Phone/Type/Segment which might not be in the row, we should probably FETCH.
        // Let's implement a fetch value to be safe and accurate.
        
        openEditCustomerModal(id); 
    });

    async function openEditCustomerModal(customerId) {
        // Show loading state or toast if needed
        let customer = null;
        try {
            // We need a route to get a single customer. 
            // Assuming /admin/customers/{id} returns json if we ask for it? 
            // The controller `show` method returns a view. We might need to adjust it or just use the row data for now if we can't fetch.
            // Wait, proper implementation requires data. Let's start by scraping the row but for the new fields (Address, Phone), they are likely not in the row.
            // Let's check the controller 'update' uses inputs. 
            // For now, let's assume we can pass the data via data-attributes on the row OR fetch.
            // Let's implement a fetch if possible. If not, I'll fallback to row data.
            // checking CustomerController.php... index method passes $customers.
            // I'll update the row to include data attributes for all fields first! No, that's brittle.
            // Best approach: Add a fetch call.
            
            // For this step, I will implement the modal UI. I'll assume we can get data.
            // I'll use a placeholder 'fetch' logic.
            
            // ACTUALLY, to avoid changing the controller 'show' method right now (which returns a view), 
            // I will rely on the fact that I can't easily fetch JSON without a new endpoint or modifying 'show'.
            // I will MODIFY the row generation in blade to include data attributes for all fields. 
            // This is safer and requires no controller changes for 'show'.
            
            // Wait, I can't modify the row generation in this specific tool call (it's a huge file).
            // I will implement the modal to accept data.
            // Let's assume for this specific step I am just replacing the JS. 
            // I'll add the data-attributes in a separate step or just use what's there and maybe leave 'Address' blank/placeholder if not available?
            // "Ensure all fields are editable and pre-filled".
            // I MUST have the data. 
            // Let's try to fetch /admin/customers/{id} with Accept: application/json. 
            // The standard Laravel resource controller `show` might not return JSON unless configured.
            // Let's check CustomerController.php... `show` returns `view('customer.show', compact('customer'))`.
            // Requesting JSON won't automatically convert that.
            
            // OK, plan B: I will render the full customer object into a global JS variable or data attribute? No, too heavy.
            // Plan C: I will update the table row to include data-json attribute with the full customer object.
            
            // For this tool call, I will replace the JS to use `openEditCustomerModal` which extracts data from a `data-json` attribute I will add to the row in the NEXT step.
            
            const row = document.querySelector(`tr[data-customer-id="${customerId}"]`);
            if (!row) return;

            // Fallback object if data-json isn't there yet (will be added next)
            const custData = JSON.parse(row.dataset.json || '{}'); 
            
            // Defaults/Fallbacks
            const name = custData.Institution_Name || row.querySelector('.customer-name')?.textContent.trim() || '';
            const contact = custData.Contact_Person || '';
            const email = custData.Email || row.querySelector('.customer-email')?.textContent.trim() || '';
            const phone = custData.Phone || '';
            const address = custData.Address || '';
            const status = custData.Status || row.querySelector('.status-badge')?.textContent.trim() || 'Active';
            const type = custData.Customer_Type || ''; 
            const priority = custData.Segment_Type || 'MediumValue';

            const body = `
                <form id="editCustomerForm" class="modal-form">
                    <input type="hidden" name="Customer_ID" value="${customerId}">
                    
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Institution Name <span class="required">*</span></label>
                            <input type="text" id="edit_company" name="Institution_Name" class="form-input" required value="${name}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Person</label>
                            <input type="text" id="edit_contact" name="Contact_Person" class="form-input" value="${contact}">
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="edit_email" name="Email" class="form-input" required value="${email}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" id="edit_phone" name="Phone" class="form-input" value="${phone}">
                        </div>
                    </div>

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Type <span class="required">*</span></label>
                            <select id="edit_type" name="Customer_Type" class="form-input" required>
                                <option value="PrivateClinic" ${type === 'PrivateClinic' ? 'selected' : ''}>Private Clinic</option>
                                <option value="Hospital" ${type === 'Hospital' ? 'selected' : ''}>Hospital</option>
                                <option value="School" ${type === 'School' ? 'selected' : ''}>School</option>
                                <option value="Government" ${type === 'Government' ? 'selected' : ''}>Government</option>
                                <option value="OtherInstitution" ${type === 'OtherInstitution' ? 'selected' : ''}>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Priority (Segment)</label>
                            <select id="edit_priority" name="Segment_Type" class="form-input">
                                <option value="MediumValue" ${priority === 'MediumValue' ? 'selected' : ''}>Medium</option>
                                <option value="HighValue" ${priority === 'HighValue' ? 'selected' : ''}>High</option>
                                <option value="LowValue" ${priority === 'LowValue' ? 'selected' : ''}>Low</option>
                                <option value="Prospect" ${priority === 'Prospect' ? 'selected' : ''}>Prospect</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea id="edit_address" name="Address" class="form-input" rows="2">${address}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select id="edit_status" name="Status" class="form-input">
                            <option value="Active" ${status === 'Active' ? 'selected' : ''}>Active</option>
                            <option value="Inactive" ${status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                            <option value="OnHold" ${status === 'OnHold' ? 'selected' : ''}>On Hold</option>
                        </select>
                    </div>

                    <div class="form-errors" id="editCustomerErrors" style="display: none;"></div>
                </form>
            `;

            const footer = `
                <button class="modal-btn secondary close-modal">Cancel</button>
                <button class="modal-btn primary" id="updateCustomerBtn">Update Changes</button>
            `;

            const modal = createModal(`Edit Customer`, body, footer);

            // Styling overrides
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.style.border = '1px solid #e2f1f1';
                content.style.maxWidth = '700px';
            }
            const title = modal.querySelector('.modal-header h3');
            if (title) {
                title.style.fontSize = '32px';
                title.style.fontWeight = '700';
                title.style.color = '#235c63';
            }

            modal.querySelector('#updateCustomerBtn').addEventListener('click', async function() {
                const form = modal.querySelector('#editCustomerForm');
                const errorsDiv = modal.querySelector('#editCustomerErrors');
                
                if (!form.checkValidity()) { form.reportValidity(); return; }

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                this.disabled = true;
                this.textContent = 'Updating...';

                try {
                    const response = await fetch(`/admin/customers/${customerId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });

                    const result = await response.json();
                    if (result.success) {
                        showToast('Customer updated successfully!', 'success');
                        closeModal(modal);
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        errorsDiv.style.display = 'block';
                        if (result.errors) {
                             errorsDiv.innerHTML = Object.values(result.errors).flat().join('<br>');
                        } else {
                            errorsDiv.innerHTML = result.message || 'Update failed';
                        }
                    }
                } catch (err) {
                    errorsDiv.innerHTML = 'Network error. Please try again.';
                    errorsDiv.style.display = 'block';
                } finally {
                    this.disabled = false;
                    this.textContent = 'Update Changes';
                }
            });
        } catch (e) {
            console.error(e);
            showToast('Error opening modal', 'error');
        }
    }



    // ========== INTERACTION LOGS MODAL ==========
    // ========== INTERACTION LOGS MODAL ==========
    document.addEventListener('click', async function(e) {
        const logsBtn = e.target.closest('.logs-btn');
        if (logsBtn) {
            e.preventDefault();
            const row = logsBtn.closest('.customer-row');
            const customerId = row.dataset.customerId;
            const customerName = row.querySelector('.customer-name')?.textContent || 'N/A';

            // Show loading state
            // Ideally we show a spinner or skeleton. For now, simple loading text.
            let logs = [];
            try {
                const res = await fetch(`/admin/customers/${customerId}/interactions`);
                const json = await res.json();
                if (json.success) {
                    logs = json.logs;
                }
            } catch (err) {
                console.error('Failed to fetch logs', err);
                showToast('Failed to load interaction history', 'error');
            }

            const buildTimelineItems = (items) => {
                if (items.length === 0) {
                     return `
                        <div class="empty-timeline" style="text-align: center; padding: 40px; color: #9ca3af; background: #f9fafb; border-radius: 8px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 12px; opacity: 0.5;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <p>No interaction logs found.</p>
                        </div>
                    `;
                }
                
                return items.map(log => {
                    const date = new Date(log.Interaction_Date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    const typeColors = {
                        'Call': 'text-blue-600 bg-blue-50',
                        'Email': 'text-purple-600 bg-purple-50',
                        'Meeting': 'text-orange-600 bg-orange-50',
                        'Other': 'text-gray-600 bg-gray-50'
                    };
                    const colorClass = typeColors[log.Interaction_Type] || typeColors['Other'];
                    
                    return `
                        <div class="timeline-item" style="display: flex; gap: 16px; padding-bottom: 24px; border-left: 2px solid #e5e7eb; padding-left: 24px; position: relative;">
                            <div class="timeline-dot" style="position: absolute; left: -9px; top: 0; width: 16px; height: 16px; background: #fff; border: 2px solid #235c63; border-radius: 50%;"></div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span style="font-weight: 600; color: #374151;">${log.Subject}</span>
                                    <span style="font-size: 12px; color: #6b7280;">${date}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <span class="badge" style="padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 500; background: #f3f4f6;">${log.Interaction_Type}</span>
                                    <span style="font-size: 12px; color: #6b7280;">by ${log.user?.name || 'Unknown'}</span>
                                </div>
                                <div style="color: #4b5563; font-size: 14px; line-height: 1.5;">
                                    ${log.Details}
                                </div>
                                ${log.Follow_Up_Date ? `
                                    <div style="margin-top: 8px; font-size: 12px; color: #d97706; display: flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        Follow up: ${new Date(log.Follow_Up_Date).toLocaleDateString()}
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const body = `
                <div class="interaction-timeline">
                    <div class="timeline-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0; color: #374151; font-size: 16px;">Activity History</h4>
                        <button class="modal-btn primary sm add-log-btn" data-customer-id="${customerId}" data-customer-name="${customerName}" style="background-color: #235c63; border: none;">+ Log Interaction</button>
                    </div>
                    <div class="timeline-items">
                        ${buildTimelineItems(logs)}
                    </div>
                </div>
            `;

            const modal = createModal(`Timeline: ${customerName}`, body, `<button class="modal-btn secondary close-modal">Close</button>`);
            
            // Timeline Modal Styling (same as before)
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.style.border = '1px solid #e2f1f1';
                content.style.maxWidth = '600px';
                // Ensure maxHeight and scroll
                const bodyDiv = modal.querySelector('.modal-body');
                bodyDiv.style.maxHeight = '60vh';
                bodyDiv.style.overflowY = 'auto';
            }
            const title = modal.querySelector('.modal-header h3');
            if (title) {
                title.style.fontSize = '24px';
                title.style.fontWeight = '700';
                title.style.color = '#235c63';
            }
        }

        // Add log handler (delegated)
        const addLogBtn = e.target.closest('.add-log-btn');
        if (addLogBtn) {
            e.preventDefault(); // Prevent default if it's a link or form submit
            const { customerId, customerName } = addLogBtn.dataset;
            const logBody = `
                <form id="addLogForm" class="modal-form">
                    <div class="form-group">
                        <label class="form-label">Subject <span class="required">*</span></label>
                        <input type="text" id="log_subject" name="Subject" class="form-input" required placeholder="e.g. Sales Call, Product Demo">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Details <span class="required">*</span></label>
                        <textarea id="log_details" name="Details" class="form-input" rows="4" placeholder="Summary of interaction..." required></textarea>
                    </div>
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select id="interaction_type" name="Interaction_Type" class="form-input">
                                <option value="Call">Call</option>
                                <option value="Email">Email</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Next Follow-up</label>
                            <input type="date" id="next_follow_up" name="Follow_Up_Date" class="form-input">
                        </div>
                    </div>
                    <div class="form-errors" id="addLogErrors" style="display: none;"></div>
                </form>
            `;
            const logModal = createModal(`New Log: ${customerName}`, logBody, `
                <button class="modal-btn secondary close-modal">Cancel</button>
                <button class="modal-btn primary" id="saveLogBtn" style="background-color: #235c63;">Save Log</button>
            `);

            // Log Modal Styling
            const content = logModal.querySelector('.modal-content');
            if (content) {
                content.style.border = '1px solid #e2f1f1';
                content.style.maxWidth = '500px'; 
                logModal.style.zIndex = '10010'; // Ensure it's above timeline
            }
            const title = logModal.querySelector('.modal-header h3');
            if (title) {
                title.style.fontSize = '24px';
                title.style.fontWeight = '700';
                title.style.color = '#235c63';
            }

            logModal.querySelector('#saveLogBtn').addEventListener('click', async function() {
                const form = logModal.querySelector('#addLogForm');
                if (!form.checkValidity()) { form.reportValidity(); return; }
                
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                data.customer_id = customerId;
                
                this.disabled = true;
                this.textContent = 'Saving...';
                
                try {
                    const response = await fetch('/admin/customers/interaction', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });

                    const result = await response.json();
                    
                    const errorsDiv = logModal.querySelector('#addLogErrors');
                    errorsDiv.style.display = 'none';

                    if (result.success) {
                        showToast('Interaction logged successfully!', 'success');
                        closeModal(logModal);
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        errorsDiv.style.display = 'block';
                        if (result.errors) {
                             errorsDiv.innerHTML = Object.values(result.errors).flat().join('<br>');
                        } else {
                            errorsDiv.innerHTML = result.message || 'Failed to save log';
                        }
                    }
                } catch (err) {
                    const errorsDiv = logModal.querySelector('#addLogErrors');
                    errorsDiv.innerHTML = 'Network error. Please try again.';
                    errorsDiv.style.display = 'block';
                } finally {
                    this.disabled = false;
                    this.textContent = 'Save Log';
                }
            });
        }
    });

    // ========== CREATE QUOTE MODAL ==========
    window.openCreateQuoteModal = function(customerId, customerName) {
        console.log('Opening Quote Modal for:', customerName);
        
        let rowCount = 0;
        
        const body = `
            <form id="createQuoteForm" class="modal-form">
                <input type="hidden" name="customer_id" value="${customerId}">
                
                <div class="form-row" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label class="form-label">Quote Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-input" required placeholder="e.g. Q4 Equipment Upgrade" value="Quote for ${customerName}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Valid Until <span class="required">*</span></label>
                        <input type="date" name="valid_until" class="form-input" required value="${new Date(Date.now() + 30*24*60*60*1000).toISOString().split('T')[0]}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="Draft">Draft</option>
                            <option value="Sent">Sent</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>

                <div class="quote-items-container" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                    <label class="form-label" style="display:block; margin-bottom: 12px;">Line Items</label>
                    <table class="quote-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #d1d5db; text-align: left;">
                                <th style="padding: 8px; width: 40%; font-size: 13px; color: #6b7280;">Product</th>
                                <th style="padding: 8px; width: 15%; font-size: 13px; color: #6b7280;">Price ($)</th>
                                <th style="padding: 8px; width: 15%; font-size: 13px; color: #6b7280;">Qty</th>
                                <th style="padding: 8px; width: 20%; font-size: 13px; color: #6b7280;">Total ($)</th>
                                <th style="padding: 8px; width: 10%;"></th>
                            </tr>
                        </thead>
                        <tbody id="quoteItemsBody">
                            <!-- Items will be added here -->
                        </tbody>
                    </table>
                    <button type="button" id="addItemBtn" class="modal-btn secondary sm" style="margin-top: 12px; width: 100%; border-style: dashed;">+ Add Item</button>
                </div>

                <div class="quote-summary" style="display: flex; justify-content: flex-end;">
                    <div style="width: 250px; text-align: right;">
                        <div style="margin-bottom: 8px; font-size: 14px; color: #6b7280;">Subtotal: <span id="quoteSubtotal" style="color: #1f2937; font-weight: 600;">$0.00</span></div>
                        <div style="margin-bottom: 8px; font-size: 14px; color: #6b7280;">VAT (12%): <span id="quoteTax" style="color: #1f2937; font-weight: 600;">$0.00</span></div>
                        <div style="font-size: 18px; color: #235c63; font-weight: 700; border-top: 1px solid #e5e7eb; padding-top: 8px;">Total: <span id="quoteTotal">$0.00</span></div>
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                    </div>
                </div>

                <div class="form-errors" id="createQuoteErrors" style="display: none;"></div>
            </form>
        `;

        const footer = `
            <button class="modal-btn secondary close-modal">Cancel</button>
            <button class="modal-btn primary" id="saveQuoteBtn">Save Quote</button>
        `;

        const modal = createModal(`New Quote`, body, footer);
        
        // Styling overrides
        const content = modal.querySelector('.modal-content');
        if (content) {
            content.style.maxWidth = '800px'; 
            content.style.border = '1px solid #e2f1f1';
        }

        // --- Logic ---
        const tbody = modal.querySelector('#quoteItemsBody');
        const addItemBtn = modal.querySelector('#addItemBtn');

        function addItem() {
            rowCount++;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="padding: 8px;">
                    <select class="form-input product-select" name="items[${rowCount}][product_id]" required>
                        <option value="">Select Product...</option>
                        ${products.map(p => `<option value="${p.Product_ID}" data-price="${p.Unit_Price_USD}">${p.Product_Name}</option>`).join('')}
                    </select>
                </td>
                <td style="padding: 8px;">
                    <input type="number" class="form-input price-input" name="items[${rowCount}][price]" step="0.01" min="0" required>
                </td>
                <td style="padding: 8px;">
                    <input type="number" class="form-input qty-input" name="items[${rowCount}][quantity]" value="1" min="1" required>
                </td>
                <td style="padding: 8px; font-weight: 600; color: #374151;">
                    <span class="row-total">$0.00</span>
                </td>
                <td style="padding: 8px; text-align: center;">
                    <button type="button" class="remove-row-btn" style="background: none; border: none; color: #ef4444; cursor: pointer;">&times;</button>
                </td>
            `;
            tbody.appendChild(tr);

            // Bind events
            const select = tr.querySelector('.product-select');
            const priceInput = tr.querySelector('.price-input');
            const qtyInput = tr.querySelector('.qty-input');
            const removeBtn = tr.querySelector('.remove-row-btn');

            select.addEventListener('change', function() {
                const price = this.options[this.selectedIndex].dataset.price || 0;
                priceInput.value = price;
                calculateTotals();
            });

            priceInput.addEventListener('input', calculateTotals);
            qtyInput.addEventListener('input', calculateTotals);
            removeBtn.addEventListener('click', function() {
                tr.remove();
                calculateTotals();
            });
        }

        function calculateTotals() {
            let subtotal = 0;
            modal.querySelectorAll('tbody tr').forEach(row => {
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                const total = price * qty;
                row.querySelector('.row-total').textContent = '$' + total.toFixed(2);
                subtotal += total;
            });

            const tax = subtotal * 0.12;
            const total = subtotal + tax;

            modal.querySelector('#quoteSubtotal').textContent = '$' + subtotal.toFixed(2);
            modal.querySelector('#quoteTax').textContent = '$' + tax.toFixed(2);
            modal.querySelector('#quoteTotal').textContent = '$' + total.toFixed(2);
            modal.querySelector('#totalAmountInput').value = subtotal.toFixed(2);
        }

        // Initialize with one row
        addItem();

        // Save options
        modal.querySelector('#addItemBtn').addEventListener('click', addItem);
        
        modal.querySelector('#saveQuoteBtn').addEventListener('click', async function() {
            const form = modal.querySelector('#createQuoteForm');
            if (!form.checkValidity()) { form.reportValidity(); return; }

            // Manual check for items
            if (modal.querySelectorAll('tbody tr').length === 0) {
                showToast('Please add at least one item', 'error');
                return;
            }

            const formData = new FormData(form);
            const data = {
                customer_id: formData.get('customer_id'),
                title: formData.get('title'),
                valid_until: formData.get('valid_until'),
                status: formData.get('status'),
                total_amount: formData.get('total_amount'),
                items: []
            };

            modal.querySelectorAll('tbody tr').forEach((row, index) => {
                data.items.push({
                    product_id: row.querySelector('.product-select').value,
                    price: row.querySelector('.price-input').value,
                    quantity: row.querySelector('.qty-input').value
                });
            });

            this.disabled = true;
            this.textContent = 'Saving...';

            try {
                const response = await fetch('/admin/customers/quotation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Quotation created successfully!', 'success');
                    closeModal(modal);
                } else {
                    const errorsDiv = modal.querySelector('#createQuoteErrors');
                    errorsDiv.innerHTML = result.message || 'Failed to create quote';
                    errorsDiv.style.display = 'block';
                    if(result.errors) console.log(result.errors);
                }
            } catch (err) {
                showToast('Network error', 'error');
            } finally {
                this.disabled = false;
                this.textContent = 'Save Quote';
            }
        });
    }

    // ========== REMINDERS MODAL (REIMAGINED) ========== 
    async function fetchRemindersData() {
        try {
            const res = await fetch('/admin/customers/reminders');
            const json = await res.json();
            return json.success ? json.reminders : [];
        } catch (e) {
            console.error('REMINDERS: Fetch failed', e);
            return [];
        }
    }

    function buildReminderCards(reminders) {
        if (!reminders || reminders.length === 0) {
            return `
                <div class="empty-reminders" style="text-align: center; padding: 40px 0; opacity: 0.5;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 16px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <p>No upcoming follow-up reminders.</p>
                </div>
            `;
        }

        return `<div class="reminders-list">` + reminders.map(rem => {
            const rawPriority = rem.priority || 'MediumValue';
            const priorityClass = rawPriority.replace('Value', '').toLowerCase();
            const label = rawPriority.replace('Value', '');
            
            // Format time
            const diff = Math.ceil((new Date(rem.due_date) - new Date()) / (1000 * 3600 * 24));
            const timeStr = diff === 0 ? 'Today' : (diff === 1 ? 'Tomorrow' : `In ${diff} days`);

            return `
                <div class="reminder-card ${priorityClass}">
                    <div class="priority-badge ${priorityClass}">${label}</div>
                    <div class="reminder-customer">${rem.customer_name}</div>
                    <div class="reminder-subject">${rem.subject}</div>
                    <div class="reminder-time">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>${timeStr}</span>
                    </div>
                </div>
            `;
        }).join('') + `</div>`;
    }

    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.reminders-btn');
        if (!btn) return;
        
        e.preventDefault();
        
        // Show immediate loading or fetch
        const reminders = await fetchRemindersData();
        const content = buildReminderCards(reminders);
        
        const modal = createModal('Follow-Up Reminders', `
            <div class="reminders-modal-content">
                ${content}
            </div>
        `, `
            <div class="reminders-footer">
                <button class="configure-triggers-btn">Configure Triggers</button>
                <button class="configure-triggers-btn close-modal">Close</button>
            </div>
        `);

        // Update modal title style for this specific modal
        const title = modal.querySelector('.modal-header h3');
        if (title) {
            title.style.fontSize = '32px';
            title.style.fontWeight = '700';
            title.style.color = '#1f2937';
        }

        // Adjust footer style
        const footer = modal.querySelector('.modal-footer');
        if (footer) {
            footer.style.justifyContent = 'space-between';
            footer.style.padding = '24px';
            footer.style.borderTop = 'none';
        }

        // Adjust header style
        const header = modal.querySelector('.modal-header');
        if (header) {
            header.style.borderBottom = 'none';
            header.style.padding = '32px 24px 12px 24px';
        }
    });

    // ========== ADD CUSTOMER MODAL ==========
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.add-customer-btn');
        if (!btn) return;
        
        e.preventDefault();

        const modal = createModal('Add New Customer', `
            <div class="create-quote-form"> <!-- Reusing form layout for consistency -->
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Institution Name <span class="required">*</span></label>
                        <input type="text" id="cust-company" class="form-input" placeholder="e.g. Manila General Hospital">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Person</label>
                        <input type="text" id="cust-name" class="form-input" placeholder="Full name">
                    </div>
                </div>
                
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" id="cust-email" class="form-input" placeholder="email@institution.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" id="cust-phone" class="form-input" placeholder="09XX-XXX-XXXX">
                    </div>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Type <span class="required">*</span></label>
                        <select id="cust-type" class="form-input">
                            <option value="PrivateClinic">Private Clinic</option>
                            <option value="Hospital">Hospital</option>
                            <option value="School">School</option>
                            <option value="Government">Government</option>
                            <option value="OtherInstitution">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority (Segment)</label>
                        <select id="cust-priority" class="form-input">
                            <option value="MediumValue">Medium</option>
                            <option value="HighValue">High</option>
                            <option value="LowValue">Low</option>
                            <option value="Prospect">Prospect</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea id="cust-address" class="form-input" rows="2" placeholder="Full business address"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="cust-status" class="form-input">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="OnHold">On Hold</option>
                    </select>
                </div>
                
                <div class="form-errors" id="addCustomerErrors" style="display: none;"></div>
            </div>
        `, `
            <div class="modal-footer quote-footer" style="justify-content: flex-start; gap: 12px; padding-top: 0;">
                <button class="save-customer-btn" id="save-new-customer-btn">Save Customer</button>
                <button class="cancel-btn close-modal">Cancel</button>
            </div>
        `);

        // Style overrides to match mockup "vibe"
        const content = modal.querySelector('.modal-content');
        if (content) {
            content.style.border = '1px solid #e2f1f1';
            content.style.maxWidth = '700px';
        }

        const title = modal.querySelector('.modal-header h3');
        if (title) {
            title.style.fontSize = '32px';
            title.style.fontWeight = '700';
            title.style.color = '#235c63';
        }

        modal.querySelector('#save-new-customer-btn').addEventListener('click', async function() {
            const data = {
                Contact_Person: modal.querySelector('#cust-name').value,
                Email: modal.querySelector('#cust-email').value,
                Institution_Name: modal.querySelector('#cust-company').value,
                Phone: modal.querySelector('#cust-phone').value,
                Address: modal.querySelector('#cust-address').value,
                Status: modal.querySelector('#cust-status').value,
                Customer_Type: modal.querySelector('#cust-type').value,
                Segment_Type: modal.querySelector('#cust-priority').value
            };

            const errorsDiv = modal.querySelector('#addCustomerErrors');
            errorsDiv.style.display = 'none';

            if (!data.Email || !data.Institution_Name) {
                errorsDiv.textContent = 'Please fill in Company and Email.';
                errorsDiv.style.display = 'block';
                return;
            }

            this.disabled = true;
            this.textContent = 'Saving...';

            try {
                const res = await fetch('/admin/customers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                const json = await res.json();
                
                if (json.success) {
                    showToast('Customer saved successfully!', 'success');
                    closeModal(modal);
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    errorsDiv.style.display = 'block';
                    if (json.errors) {
                         // Format validation errors
                         errorsDiv.innerHTML = Object.values(json.errors).flat().join('<br>');
                    } else {
                        errorsDiv.textContent = json.message || 'Failed to save customer';
                    }
                }
            } catch (e) {
                errorsDiv.textContent = 'An error occurred during submission';
                errorsDiv.style.display = 'block';
            } finally {
                this.disabled = false;
                this.textContent = 'Save Customer';
            }
        });
    });

    // ========== CREATE QUOTE MODAL ==========
    async function fetchProducts() {
        try {
            const res = await fetch('/products/search?q='); // Fetch all or search
            const json = await res.json();
            return json.success ? json.products : [];
        } catch (e) {
            console.error('QUOTE: Fetch products failed', e);
            return [];
        }
    }

    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.quote-btn');
        if (!btn) return;
        
        e.preventDefault();
        
        let products = await fetchProducts();
        
        const modal = createModal('Create New Quotation', `
            <div class="create-quote-form">
                <div class="form-group">
                    <label class="form-label">Customer</label>
                    <select id="quote-customer" class="form-input">
                        @foreach($customers as $c)
                            <option value="{{ $c->Customer_ID }}">{{ $c->Institution_Name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Quote Title</label>
                    <input type="text" id="quote-title" class="form-input" placeholder="e.g., Ultrasound Equipment Package">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Products / Items</label>
                    <div id="quote-products-list" class="products-selector-container">
                        <div class="product-row header">
                            <span style="font-size: 13px; font-weight: 600; color: #6b7280;">Product</span>
                            <span style="font-size: 13px; font-weight: 600; color: #6b7280;">Qty</span>
                            <span style="font-size: 13px; font-weight: 600; color: #6b7280;">Price ($)</span>
                            <span></span>
                        </div>
                        <div id="product-rows-container">
                            <!-- Rows added dynamically -->
                        </div>
                    </div>
                    <button type="button" class="add-product-row-btn">+ Add Product</button>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Total Amount ($)</label>
                    <input type="number" id="quote-total" class="form-input" placeholder="0.00" readonly>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Valid Until</label>
                    <input type="date" id="quote-expiry" class="form-input">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Stage</label>
                    <select id="quote-stage" class="form-input">
                        <option value="Draft">Draft</option>
                        <option value="Pending">Pending</option>
                        <option value="Sent">Sent</option>
                    </select>
                </div>
            </div>
        `, `
            <div class="modal-footer quote-footer">
                <button class="cancel-quote-btn close-modal">Cancel</button>
                <button class="generate-send-btn" id="submit-quote-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Generate & Send
                </button>
            </div>
        `);

        // Update modal title style
        const title = modal.querySelector('.modal-header h3');
        if (title) {
            title.style.fontSize = '32px';
            title.style.fontWeight = '700';
            title.style.color = '#1f2937';
        }

        const rowsContainer = modal.querySelector('#product-rows-container');
        const totalInput = modal.querySelector('#quote-total');
        
        function addRow() {
            const row = document.createElement('div');
            row.className = 'product-row';
            row.innerHTML = `
                <select class="form-input product-select" style="padding: 8px 12px; font-size: 14px;">
                    <option value="">Select Product...</option>
                    ${products.map(p => `<option value="${p.Product_ID}" data-price="${p.Unit_Price_USD}">${p.Product_Name}</option>`).join('')}
                </select>
                <input type="number" class="form-input product-qty" value="1" min="1" style="padding: 8px; text-align: center;">
                <input type="number" class="form-input product-price" placeholder="0.00" style="padding: 8px; background: #f9fafb;" readonly>
                <button type="button" class="remove-row" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 20px;">&times;</button>
            `;
            rowsContainer.appendChild(row);
            
            // Listeners for auto-calc
            row.querySelector('.product-select').addEventListener('change', (e) => {
                const opt = e.target.options[e.target.selectedIndex];
                const price = opt.dataset.price || 0;
                row.querySelector('.product-price').value = price;
                updateTotal();
            });
            row.querySelector('.product-qty').addEventListener('input', updateTotal);
            row.querySelector('.remove-row').addEventListener('click', () => {
                row.remove();
                updateTotal();
            });
        }

        function updateTotal() {
            let total = 0;
            rowsContainer.querySelectorAll('.product-row').forEach(row => {
                const price = parseFloat(row.querySelector('.product-price').value) || 0;
                const qty = parseInt(row.querySelector('.product-qty').value) || 0;
                total += price * qty;
            });
            totalInput.value = total.toFixed(2);
        }

        modal.querySelector('.add-product-row-btn').addEventListener('click', addRow);
        
        // Add initial row
        addRow();

        // Submit logic
        modal.querySelector('#submit-quote-btn').addEventListener('click', async () => {
            const data = {
                customer_id: modal.querySelector('#quote-customer').value,
                title: modal.querySelector('#quote-title').value,
                items: [],
                total_amount: modal.querySelector('#quote-total').value,
                valid_until: modal.querySelector('#quote-expiry').value,
                status: modal.querySelector('#quote-stage').value
            };

            rowsContainer.querySelectorAll('.product-row').forEach(row => {
                const prodId = row.querySelector('.product-select').value;
                if (prodId) {
                    data.items.push({
                        product_id: prodId,
                        quantity: row.querySelector('.product-qty').value,
                        price: row.querySelector('.product-price').value
                    });
                }
            });

            if (data.items.length === 0) {
                alert('Please add at least one product.');
                return;
            }

            try {
                const res = await fetch('/admin/customers/quotation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                const json = await res.json();
                if (json.success) {
                    showToast('Quotation created successfully!', 'success');
                    modal.querySelector('.close-modal').click();
                } else {
                    showToast(json.message || 'Failed to create quotation', 'error');
                }
            } catch (e) {
                showToast('An error occurred during submission', 'error');
            }
        });
    });

    // ========== ANIMATIONS ==========
    document.querySelectorAll('.stat-card').forEach((card, i) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        }, i * 100);
    });

    document.querySelectorAll('.customer-row').forEach((row, i) => {
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, i * 100 + 300);
    });
});
</script>



{{-- Modal Styles --}}
<style>
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
}
.modal-overlay.show { opacity: 1; visibility: visible; }
.modal-content {
    background: #fff; border-radius: 16px; width: 90%; max-width: 600px;
    max-height: 90vh; overflow-y: auto;
    transform: translateY(-20px); transition: transform 0.3s ease;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
.modal-overlay.show .modal-content { transform: translateY(0); }
.modal-header {
    padding: 20px 24px; border-bottom: 1px solid #e5e7eb;
    display: flex; justify-content: space-between; align-items: center;
}
.modal-header h3 { margin: 0; color: #235c63; font-size: 18px; }
.close-modal {
    background: none; border: none; font-size: 24px; color: #6b7280;
    cursor: pointer; width: 32px; height: 32px; display: flex;
    align-items: center; justify-content: center; border-radius: 50%;
    transition: all 0.2s;
}
.close-modal:hover { background: #f3f4f6; color: #374151; }
.modal-body { padding: 24px; }
.modal-footer {
    padding: 16px 24px; border-top: 1px solid #e5e7eb;
    display: flex; justify-content: flex-end; gap: 12px;
}
.modal-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.modal-form .form-group { margin-bottom: 16px; }
.modal-form label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; font-size: 14px; }
.modal-form .required { color: #ef4444; }
.form-input, .form-select, .form-textarea {
    width: 100%; padding: 10px 12px; border: 1px solid #d1d5db;
    border-radius: 8px; font-size: 14px; transition: border-color 0.2s;
    box-sizing: border-box;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none; border-color: #2f7a85; box-shadow: 0 0 0 3px rgba(47,122,133,0.1);
}
.form-errors {
    background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;
    padding: 12px 16px; color: #dc2626; font-size: 14px; margin-top: 8px;
}
.modal-btn {
    padding: 10px 20px; border-radius: 8px; border: none;
    font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s;
}
.modal-btn.primary { background: #2f7a85; color: #fff; }
.modal-btn.primary:hover { background: #235c63; }
.modal-btn.primary:disabled { background: #9ca3af; cursor: not-allowed; }
.modal-btn.secondary { background: #f3f4f6; color: #374151; }
.modal-btn.secondary:hover { background: #e5e7eb; }

.customer-detail .detail-row {
    display: flex; justify-content: space-between; padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}
.detail-label { font-weight: 500; color: #6b7280; }
.detail-value { color: #111827; }

.crm-toast {
    position: fixed; top: 20px; right: 20px; padding: 12px 20px;
    border-radius: 8px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateX(calc(100% + 20px)); transition: transform 0.3s;
    z-index: 1001; font-size: 14px;
}
.crm-toast.show { transform: translateX(0); }
.toast-success { border-left: 4px solid #10b981; color: #065f46; }
.toast-error { border-left: 4px solid #ef4444; color: #991b1b; }
.toast-info { border-left: 4px solid #3b82f6; color: #1e40af; }

@media (max-width: 640px) {
    .modal-form .form-row { grid-template-columns: 1fr; }
    .modal-content { width: 95%; max-width: none; }
}
</style>