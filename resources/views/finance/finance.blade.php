@vite(['resources/css/finance.css'])
<div class="admin-dashboard-container">
    <!-- Sidebar Component -->
    @include('components.sidebar')

    <main class="admin-main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Finance</h1>
        </div>

        <div class="admin-crm">
            <div class="crm-unified-card">
                <!-- Unified Header: Title + Actions -->
                <div class="crm-header-row">
                    <div class="crm-title-section">
                        <span class="financial-dashboard-label">Financial Dashboard</span>
                    </div>
                    
                    <div class="crm-actions">
                        <button class="action-btn ghost-btn payment-plans-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Payment Plans</span>
                        </button>
                        <button class="action-btn ghost-btn overdue-alerts-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>Overdue Alerts</span>
                        </button>
                        <button class="action-btn primary-teal-btn generate-invoice-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                            <span>Generate Invoice</span>
                        </button>
                    </div>
                </div>
            
                
                <div class="finance-stats">
                    @php
                        $paidTotal = isset($sales) ? $sales->where('Status', 'Completed')->sum('Total_Amount_PHP') : 0;
                        $unpaidTotal = isset($sales) ? $sales->where('Status', 'Pending')->sum('Total_Amount_PHP') : 0;
                        $overdueTotal = isset($overdueSales) ? $overdueSales->sum('Total_Amount_PHP') : 0;
                        $totalSales = isset($sales) ? $sales->count() : 0;

                        $financeStats = [
                            [
                                'label' => 'Paid',
                                'amount' => '₱' . number_format($paidTotal, 0),
                                'class' => 'paid'
                            ],
                            [
                                'label' => 'Unpaid',
                                'amount' => '₱' . number_format($unpaidTotal, 0),
                                'class' => 'unpaid'
                            ],
                            [
                                'label' => 'Overdue',
                                'amount' => '₱' . number_format($overdueTotal, 0),
                                'class' => 'overdue'
                            ],
                            [
                                'label' => 'Total Invoices',
                                'amount' => $totalSales,
                                'class' => 'total'
                            ]
                        ];
                    @endphp
                    
                    @foreach($financeStats as $stat)
                        <div class="stat-card {{ $stat['class'] }}">
                            <div class="stat-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div class="stat-amount">{{ $stat['amount'] }}</div>
                            <div class="stat-label">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="exchange-rate-block">
                    <div class="exchange-header">
                        <div class="exchange-title-container">
                            <div class="exchange-icon-box">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                    <polyline points="17 6 23 6 23 12"></polyline>
                                </svg>
                            </div>
                            <div class="exchange-title-texts">
                                <h3 class="main-title">Exchange Rate Monitor</h3>
                                <p class="sub-title">USD to Local Currency</p>
                            </div>
                        </div>
                        <div class="auto-fetch-badge">Auto-Fetch: ON</div>
                    </div>
                    <div class="rate-info-grid">
                        <div class="info-item">
                            <span class="label">Current Rate</span>
                            <span class="value">1.35 LC/USD</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Last Updated</span>
                            <span class="value">2 hours ago</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Update Source</span>
                            <span class="value">Automated</span>
                        </div>
                    </div>
                    <div class="threshold-alert">
                        <div class="alert-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div class="alert-text">
                            Threshold Alert: Exchange rate has exceeded threshold (below 1.30). Dollar-denominated balances have been recalculated. Review pricing adjustments recommended.
                        </div>
                    </div>
                </div>
                
                <div class="sales-table-container">
                    <table class="finance-table">
                        <thead>
                            <tr>
                                <th class="table-header">Invoice ID</th>
                                <th class="table-header">Customer</th>
                                <th class="table-header">Amount</th>
                                <th class="table-header">Due Date</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $index => $sale)
                                <tr class="sale-row" data-sale-id="{{ $sale->Sale_ID }}">
                                    <td class="table-cell">
                                        <div class="sale-id-text">#SL-{{ str_pad($sale->Sale_ID, 5, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="customer-name">{{ $sale->customer->Institution_Name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="amount-text">₱{{ number_format($sale->Total_Amount_PHP, 2) }}</div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="date-text">{{ \Carbon\Carbon::parse($sale->Sale_Date)->format('M d, Y') }}</div>
                                    </td>
                                    <td class="table-cell">
                                        <span class="status-badge {{ strtolower($sale->Status) }}">
                                            {{ ucfirst($sale->Status) }}
                                        </span>
                                    </td>
                                    <td class="table-cell">
                                        <div class="table-actions">
                                            @if($sale->Status !== 'Completed' && $sale->Status !== 'Paid')
                                            <a href="#" class="record-payment-link record-payment-btn" data-sale-id="{{ $sale->Sale_ID }}" data-sale-num="SL-{{ str_pad($sale->Sale_ID, 5, '0', STR_PAD_LEFT) }}" data-total="{{ $sale->Total_Amount_PHP }}" data-paid="{{ $sale->Amount_Paid ?? 0 }}">
                                                Record Payment
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="table-empty">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>
    </main>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // ========== MODAL SYSTEM ==========

    function createModal(title, bodyHTML, footerHTML) {
        const overlay = document.createElement('div');
        overlay.className = 'fin-modal-overlay';
        overlay.innerHTML = `
            <div class="fin-modal-content">
                <div class="fin-modal-header">
                    <h3>${title}</h3>
                    <button class="fin-close-modal">&times;</button>
                </div>
                <div class="fin-modal-body">${bodyHTML}</div>
                <div class="fin-modal-footer">${footerHTML}</div>
            </div>
        `;
        document.body.appendChild(overlay);
        requestAnimationFrame(() => overlay.classList.add('show'));

        overlay.querySelectorAll('.fin-close-modal').forEach(btn => {
            btn.addEventListener('click', () => closeModal(overlay));
        });
        overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(overlay); });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') { closeModal(overlay); document.removeEventListener('keydown', handler); }
        });
        return overlay;
    }

    function closeModal(overlay) {
        overlay.classList.remove('show');
        setTimeout(() => overlay.remove(), 300);
    }

    function showToast(msg, type = 'success') {
        const existing = document.querySelector('.fin-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `fin-toast toast-${type}`;
        toast.innerHTML = `<span>${msg}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 3000);
    }

    // Customer options
    const customerOptions = `
        <option value="">Select Customer</option>
        @if(isset($customers))
        @foreach($customers as $c)
        <option value="{{ $c->Customer_ID }}">{{ $c->Institution_Name }}</option>
        @endforeach
        @endif
    `;

    // ========== GENERATE INVOICE MODAL ==========

    document.querySelector('.generate-invoice-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const body = `
            <form id="saleForm" class="fin-modal-form">
                <div class="fin-form-group">
                    <label>Customer</label>
                    <select name="customer_id" class="fin-form-select" required>${customerOptions}</select>
                </div>
                <div class="fin-form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" class="fin-form-input" min="1" step="0.01" required placeholder="₱0.00">
                </div>
                <div class="fin-form-group">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="fin-form-input" required>
                </div>
                <div class="fin-form-group">
                    <label>Description</label>
                    <textarea name="notes" class="fin-form-textarea" placeholder="Invoice description..."></textarea>
                </div>
                <div class="fin-form-group">
                    <label>Payment Terms</label>
                    <select name="payment_terms" class="fin-form-select">
                        <option value="Next 30 Days">Next 30 Days</option>
                        <option value="Next 60 Days">Next 60 Days</option>
                        <option value="Immediate">Immediate Payment</option>
                    </select>
                </div>
                <input type="hidden" name="sale_date" value="${new Date().toISOString().split('T')[0]}">
                <div class="fin-form-errors" style="display:none; margin-top: 15px;"></div>
            </form>
        `;
        const footer = `
            <div class="gen-inv-footer">
                <button class="cancel-btn-text fin-close-modal">Cancel</button>
                <button class="fin-btn primary" id="submitSale">Generate & Email</button>
            </div>
        `;
        const modal = createModal('Generate New Invoice', body, footer);

        // Default due date to 30 days from now
        const dueDate = new Date();
        dueDate.setDate(dueDate.getDate() + 30);
        modal.querySelector('input[name="due_date"]').value = dueDate.toISOString().split('T')[0];

        modal.querySelector('#submitSale').addEventListener('click', async function() {
            await submitForm(modal, '#saleForm', '{{ route("admin.finance.sale") }}', 'Invoice generated and emailed!');
        });
    });

    // ========== RECORD PAYMENT (per invoice row) ==========

    document.querySelectorAll('.record-payment-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const saleId = this.dataset.saleId;
            const row = this.closest('.sale-row');
            const saleNum = row?.querySelector('.sale-id-text')?.textContent || 'SL-' + saleId;

            const body = `
                <form id="paymentForm" class="fin-modal-form">
                    <div class="fin-form-group">
                        <label>Invoice ID</label>
                        <input type="text" class="fin-form-input" value="${saleNum}" readonly style="background: #f9fafb;">
                    </div>
                    <div class="fin-form-group">
                        <label>Amount Paid</label>
                        <input type="number" name="amount_paid" class="fin-form-input" min="0.01" step="0.01" required placeholder="₱0.00">
                    </div>
                    <div class="fin-form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" class="fin-form-select" required>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Check">Check</option>
                            <option value="GCash">GCash</option>
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>
                    <div class="fin-form-group">
                        <label>Payment Date</label>
                        <input type="date" name="payment_date" class="fin-form-input" required value="${new Date().toISOString().split('T')[0]}">
                    </div>
                    <div class="fin-form-group">
                        <label>Reference / Transaction ID</label>
                        <input type="text" name="payment_reference" class="fin-form-input" placeholder="Optional">
                    </div>
                    <div class="payment-notice-box">
                        <p>Remaining balance will be updated automatically</p>
                    </div>
                    <div class="fin-form-errors" style="display:none; margin-top: 15px;"></div>
                </form>
            `;
            const footer = `
                <div class="gen-inv-footer">
                    <button class="cancel-btn-text fin-close-modal">Cancel</button>
                    <button class="fin-btn primary" id="confirmPayment">Confirm Payment</button>
                </div>
            `;
            const modal = createModal('Record Payment', body, footer);

            modal.querySelector('#confirmPayment').addEventListener('click', async function() {
                await submitForm(modal, '#paymentForm', `/admin/finance/sale/${saleId}/payment`, 'Payment recorded successfully!');
            });
        });
    });

    // ========== PAYMENT PLANS MODAL ==========

    document.querySelector('.payment-plans-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        let cards = '';
        @if(isset($paymentPlans) && $paymentPlans->count() > 0)
            @foreach($paymentPlans as $plan)
            @php
                $paidCount = $plan->installments->where('Payment_Status', 'Paid')->count();
                $nextInstallment = $plan->installments->where('Payment_Status', '!=', 'Paid')->sortBy('Due_Date')->first();
                $nextDueDate = $nextInstallment ? \Carbon\Carbon::parse($nextInstallment->Due_Date)->format('Y-m-d') : 'Completed';
                $progress = ($plan->Payment_Term_Months > 0) ? ($paidCount / $plan->Payment_Term_Months) * 100 : 0;
            @endphp
            cards += `
                <div class="pp-card" data-plan-id="{{ $plan->Payment_Plan_ID }}">
                    <div class="pp-card-header">
                        <span class="pp-id">PP-{{ str_pad($plan->Payment_Plan_ID, 3, '0', STR_PAD_LEFT) }}</span>
                        <span class="pp-status {{ strtolower($plan->Status) }}">{{ $plan->Status }}</span>
                    </div>
                    <div class="pp-details">
                        <div class="pp-detail-item">Customer: <strong>{{ addslashes($plan->sale->customer->Institution_Name ?? 'N/A') }}</strong></div>
                        <div class="pp-detail-item">Total Amount: <strong>₱{{ number_format($plan->Total_Amount ?? 0, 0) }}</strong></div>
                        <div class="pp-detail-item">Installments: <strong>{{ $paidCount }} / {{ $plan->Payment_Term_Months }} paid</strong></div>
                        <div class="pp-detail-item">Next Due: <strong>{{ $nextDueDate }}</strong></div>
                    </div>
                    <div class="pp-progress-container">
                        <div class="pp-progress-bar" style="width: {{ $progress }}%"></div>
                    </div>
                    <button class="view-plan-details-btn" style="margin-top: 12px; width: 100%; padding: 8px; border-radius: 6px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-weight: 500; cursor: pointer;">
                        Manage Plan
                    </button>
                </div>
            `;
            @endforeach
        @endif

        if (!cards) cards = '<div style="text-align:center;padding:2rem;color:#64748b;">No payment plans found.</div>';

        const body = `
            <button class="create-plan-full-btn" id="createNewPlanBtn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Create New Payment Plan
            </button>
            <div class="pp-list-container">
                ${cards}
            </div>
        `;
        const modal = createModal('Payment Plans', body, `<button class="fin-btn secondary fin-close-modal">Close</button>`);

        modal.querySelector('#createNewPlanBtn').addEventListener('click', function() {
            closeModal(modal);
            openCreatePlanModal();
        });

        modal.querySelectorAll('.view-plan-details-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const planId = this.closest('.pp-card').dataset.planId;
                openPlanDetailsModal(planId);
            });
        });
    });

    function openCreatePlanModal() {
        const body = `
            <form id="paymentPlanForm" class="fin-modal-form">
                <div class="fin-form-group">
                    <label>Customer</label>
                    <select name="customer_id" class="fin-form-select" required>${customerOptions}</select>
                </div>
                <div class="fin-form-group">
                    <label>Total Amount (₱)</label>
                    <input type="number" name="total_amount" class="fin-form-input" min="1" step="0.01" required placeholder="0.00">
                </div>
                <div class="fin-form-group">
                    <label>Number of Installments</label>
                    <input type="number" name="installments" class="fin-form-input" min="2" required placeholder="Enter number">
                </div>
                <div class="fin-form-group">
                    <label>First Payment Due Date</label>
                    <input type="date" name="first_due_date" class="fin-form-input" required>
                </div>
                <div class="fin-form-group">
                    <label>Payment Frequency</label>
                    <select name="frequency" class="fin-form-select" required>
                        <option value="monthly">Monthly</option>
                        <option value="bi-weekly">Bi-weekly</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
                <div class="pp-notice-box">
                    <p>Payment schedule will be auto-calculated</p>
                </div>
                <div class="fin-form-errors" style="display:none; margin-top: 15px;"></div>
            </form>
        `;
        const footer = `
            <button class="cancel-txt-btn fin-close-modal">Cancel</button>
            <button class="fin-btn primary" id="submitPlan">Create Plan</button>
        `;
        const modal = createModal('Create Payment Plan', body, footer);

        // Default first due date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        modal.querySelector('input[name="first_due_date"]').value = tomorrow.toISOString().split('T')[0];

        modal.querySelector('#submitPlan').addEventListener('click', async function() {
            await submitForm(modal, '#paymentPlanForm', '{{ route("admin.finance.payment-plan") }}', 'Payment plan created successfully!');
        });
    }

    async function openPlanDetailsModal(planId) {
        try {
            const response = await fetch(`/admin/finance/payment-plan/${planId}`);
            const data = await response.json();
            if (!data.success) {
                showToast(data.message, 'error');
                return;
            }

            const plan = data.plan;
            const body = `
                <div class="pp-details-view">
                    <div class="pp-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; padding: 16px; background: #f8fafc; border-radius: 8px;">
                        <div>
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Customer</div>
                            <div style="font-weight: 600;">${plan.sale.customer.Institution_Name}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Total Amount</div>
                            <div style="font-weight: 600;">₱${parseFloat(plan.Total_Amount).toLocaleString()}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Status</div>
                            <span class="pp-status ${plan.Status.toLowerCase()}">${plan.Status}</span>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Terms</div>
                            <div style="font-weight: 600;">${plan.Payment_Term_Months} Installments</div>
                        </div>
                    </div>
                    
                    <h4 style="margin-bottom: 12px; font-size: 15px; color: #1e293b;">Installment Schedule</h4>
                    <div style="overflow-x: auto;">
                        <table class="fin-report-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${plan.installments.map(inst => `
                                    <tr>
                                        <td>${inst.Installment_Number}</td>
                                        <td>${new Date(inst.Due_Date).toLocaleDateString()}</td>
                                        <td>₱${parseFloat(inst.Total_Due).toLocaleString()}</td>
                                        <td>
                                            <span style="padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;" 
                                                  class="status-${inst.Payment_Status.toLowerCase()}">
                                                ${inst.Payment_Status}
                                            </span>
                                        </td>
                                        <td>
                                            ${inst.Payment_Status !== 'Paid' ? `
                                                <button class="pay-installment-btn" data-id="${inst.Installment_ID}" data-amount="${inst.Total_Due}"
                                                        style="background: #2f7a85; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                                    Pay
                                                </button>
                                            ` : '<span style="color: #10b981;">✓</span>'}
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            const modal = createModal(`Plan PP-${planId.toString().padStart(3, '0')}`, body, `<button class="fin-btn secondary fin-close-modal">Close</button>`);

            modal.querySelectorAll('.pay-installment-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const instId = this.dataset.id;
                    const amount = this.dataset.amount;
                    closeModal(modal);
                    openPayInstallmentModal(instId, amount, planId);
                });
            });

        } catch (err) {
            showToast('Network error', 'error');
        }
    }

    function openPayInstallmentModal(instId, amount, planId) {
        const body = `
            <form id="payInstallmentForm" class="fin-modal-form">
                <div class="fin-form-group">
                    <label>Amount (₱)</label>
                    <input type="number" name="amount_paid" class="fin-form-input" value="${amount}" step="0.01" required>
                </div>
                <div class="fin-form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" class="fin-form-select" required>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Check">Check</option>
                        <option value="GCash">GCash</option>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                    </select>
                </div>
                <div class="fin-form-group">
                    <label>Payment Date</label>
                    <input type="date" name="payment_date" class="fin-form-input" value="${new Date().toISOString().split('T')[0]}" required>
                </div>
                <div class="fin-form-group">
                    <label>Reference #</label>
                    <input type="text" name="payment_reference" class="fin-form-input" placeholder="Optional">
                </div>
                <div class="fin-form-errors" style="display:none; margin-top: 15px;"></div>
            </form>
        `;
        const footer = `
            <button class="fin-btn secondary fin-back-to-plan">Back</button>
            <button class="fin-btn primary" id="confirmInstPayment">Confirm Payment</button>
        `;
        const modal = createModal('Record Installment Payment', body, footer);

        modal.querySelector('.fin-back-to-plan').addEventListener('click', () => {
            closeModal(modal);
            openPlanDetailsModal(planId);
        });

        modal.querySelector('#confirmInstPayment').addEventListener('click', async function() {
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Processing...';

            try {
                const form = modal.querySelector('#payInstallmentForm');
                const formData = new FormData(form);
                const response = await fetch(`/admin/finance/installment/${instId}/pay`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                const result = await response.json();
                if (result.success) {
                    showToast(result.message);
                    closeModal(modal);
                    openPlanDetailsModal(planId); // Return to plan view
                } else {
                    showToast(result.message, 'error');
                    btn.disabled = false;
                    btn.textContent = 'Confirm Payment';
                }
            } catch (err) {
                showToast('Network error', 'error');
                btn.disabled = false;
                btn.textContent = 'Confirm Payment';
            }
        });
    }

    // ========== OVERDUE ALERTS MODAL ==========

    document.querySelector('.overdue-alerts-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        let cards = '';
        @if(isset($overdueSales) && $overdueSales->count() > 0)
            @foreach($overdueSales as $sale)
            cards += `
                <div class="overdue-card">
                    <div class="overdue-card-header">
                        <span class="overdue-inv-id">INV-{{ str_pad($sale->Sale_ID, 3, "0", STR_PAD_LEFT) }}</span>
                        <span class="overdue-badge-red">Overdue</span>
                    </div>
                    <div class="overdue-card-details">
                        <div class="overdue-detail-row">Customer: <strong>{{ addslashes($sale->customer->Institution_Name ?? "N/A") }}</strong></div>
                        <div class="overdue-detail-row">Amount: <strong>₱{{ number_format($sale->Total_Amount_PHP ?? 0, 2) }}</strong></div>
                        <div class="overdue-detail-row">Due Date: <strong>{{ $sale->Sale_Date ? \Carbon\Carbon::parse($sale->Sale_Date)->format('M d, Y') : "N/A" }}</strong></div>
                    </div>
                    <button class="send-reminder-btn" data-sale-id="{{ $sale->Sale_ID }}">Send Reminder</button>
                </div>
            `;
            @endforeach
        @endif

        if (!cards) cards = '<div style="text-align:center;padding:2rem;color:#64748b;">No overdue transactions. 🎉</div>';

        const body = `
            <div class="overdue-list-container">
                ${cards}
            </div>
        `;
        const modal = createModal('Overdue Invoice Alerts', body, `<div class="close-right-footer"><button class="fin-btn secondary fin-close-modal">Close</button></div>`);

        modal.querySelectorAll('.send-reminder-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const saleId = this.dataset.saleId;
                showToast(`Reminder sent for INV-${saleId.padStart(3, '0')}!`, 'success');
            });
        });
    });

    // ========== FORM HELPER ==========

    async function submitForm(modal, formSelector, url, successMsg) {
        const form = modal.querySelector(formSelector);
        const errorsDiv = modal.querySelector('.fin-form-errors');
        const submitBtn = modal.querySelector('.fin-btn.primary');

        // Fallback for label if not nested in spans
        const label = submitBtn?.querySelector('.btn-label') || submitBtn;
        const originalLabel = label ? label.textContent : '';

        if (errorsDiv) { errorsDiv.style.display = 'none'; errorsDiv.innerHTML = ''; }
        if (!form.checkValidity()) { form.reportValidity(); return; }

        const data = Object.fromEntries(new FormData(form).entries());
        submitBtn.disabled = true;
        if (label) label.textContent = 'Saving...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify(data),
            });
            const result = await response.json();

            if (response.ok && (result.success || result.invoice)) {
                showToast(successMsg, 'success');
                closeModal(modal);
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (errorsDiv) {
                    errorsDiv.innerHTML = result.errors ? Object.values(result.errors).flat().join('<br>') : (result.message || 'Operation failed.');
                    errorsDiv.style.display = 'block';
                }
            }
        } catch (err) {
            if (errorsDiv) { errorsDiv.innerHTML = 'Network error.'; errorsDiv.style.display = 'block'; }
        } finally {
            if (submitBtn) submitBtn.disabled = false;
            if (label && originalLabel) label.textContent = originalLabel;
        }
    }

    // ========== ANIMATIONS ==========

    document.querySelectorAll('.stat-card').forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px) scale(0.9)';
        card.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0) scale(1)'; }, i * 150);
    });

    document.querySelectorAll('.invoice-row').forEach((row, i) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.3s ease';
        setTimeout(() => { row.style.opacity = '1'; row.style.transform = 'translateY(0)'; }, 600 + i * 100);
    });

    // Toggle button
    const toggleBtn = document.querySelector('.toggle-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            const isActive = this.classList.contains('active');
            this.textContent = isActive ? 'ON' : 'OFF';
        });
    }
});
</script>



{{-- Finance Modal Styles --}}
<style>
.fin-modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
}
.fin-modal-overlay.show { opacity: 1; visibility: visible; }
.fin-modal-content {
    background: #fff; border-radius: 16px; width: 90%; max-width: 560px;
    max-height: 90vh; overflow-y: auto;
    transform: translateY(-20px); transition: transform 0.3s ease;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
.fin-modal-overlay.show .fin-modal-content { transform: translateY(0); }
.fin-modal-header {
    padding: 20px 24px; border-bottom: 1px solid #e5e7eb;
    display: flex; justify-content: space-between; align-items: center;
}
.fin-modal-header h3 { margin: 0; color: #235c63; font-size: 18px; }
.fin-close-modal {
    background: none; border: none; font-size: 24px; color: #6b7280;
    cursor: pointer; width: 32px; height: 32px; display: flex;
    align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s;
}
.fin-close-modal:hover { background: #f3f4f6; color: #374151; }
.fin-modal-body { padding: 24px; }
.fin-modal-footer {
    padding: 16px 24px; border-top: 1px solid #e5e7eb;
    display: flex; justify-content: flex-end; gap: 12px;
}
.fin-modal-form .fin-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.fin-form-group { margin-bottom: 16px; }
.fin-form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; font-size: 14px; }
.fin-form-group .required { color: #ef4444; }
.fin-form-input, .fin-form-select {
    width: 100%; padding: 10px 12px; border: 1px solid #d1d5db;
    border-radius: 8px; font-size: 14px; transition: border-color 0.2s; box-sizing: border-box;
}
.fin-form-input:focus, .fin-form-select:focus {
    outline: none; border-color: #2f7a85; box-shadow: 0 0 0 3px rgba(47,122,133,0.1);
}
.fin-form-errors {
    background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;
    padding: 12px 16px; color: #dc2626; font-size: 14px;
}
.fin-btn {
    padding: 10px 20px; border-radius: 8px; border: none;
    font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s;
}
.fin-btn.primary { background: #2f7a85; color: #fff; }
.fin-btn.primary:hover { background: #235c63; }
.fin-btn.primary:disabled { background: #9ca3af; cursor: not-allowed; }
.fin-btn.secondary { background: #f3f4f6; color: #374151; }
.fin-btn.secondary:hover { background: #e5e7eb; }
.fin-report-table { width: 100%; border-collapse: collapse; }
.fin-report-table th, .fin-report-table td {
    padding: 10px 12px; text-align: left; border-bottom: 1px solid #f3f4f6; font-size: 14px;
}
.fin-report-table th { font-weight: 600; color: #374151; background: #f9fafb; }
.fin-confirm-content p { margin: 8px 0; }
.fin-toast {
    position: fixed; top: 20px; right: 20px; padding: 12px 20px;
    border-radius: 8px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateX(calc(100% + 20px)); transition: transform 0.3s; z-index: 1001; font-size: 14px;
}
.fin-toast.show { transform: translateX(0); }
.toast-success { border-left: 4px solid #10b981; color: #065f46; }
.toast-error { border-left: 4px solid #ef4444; color: #991b1b; }
@media (max-width: 640px) { .fin-modal-form .fin-form-row { grid-template-columns: 1fr; } }
</style>
