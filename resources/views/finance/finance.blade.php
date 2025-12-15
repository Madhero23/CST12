@vite(['resources/css/sidebar.css'])
@vite(['resources/css/finance.css'])
<div class="finance-window">
    @include("components.sidebar")
  <div class="admin-finance">
    <div class="container5">
      <div class="heading-1">
        <div class="finance2">Finance</div>
      </div>
    </div>
    <div class="container6">
      <div class="container7">
        <div class="heading-2">
          <div class="financial-dashboard">Financial Dashboard</div>
        </div>
        <div class="container8">
          <div class="button5">
            <img class="icon8" src="icon7.svg" />
            <div class="payment-plans">Payment Plans</div>
          </div>
          <div class="button6">
            <img class="icon9" src="icon8.svg" />
            <div class="overdue-alerts">Overdue Alerts</div>
          </div>
        </div>
      </div>
      <div class="container9">
        <div class="container10">
          <div class="container11">
            <img class="icon10" src="icon9.svg" />
          </div>
          <div class="container12">
            <div class="_10-590-300">₱10,590,300</div>
          </div>
          <div class="container13">
            <div class="paid">Paid</div>
          </div>
        </div>
        <div class="container14">
          <div class="container11">
            <img class="icon11" src="icon10.svg" />
          </div>
          <div class="container12">
            <div class="_2-408-000">₱2,408,000</div>
          </div>
          <div class="container13">
            <div class="unpaid">Unpaid</div>
          </div>
        </div>
        <div class="container15">
          <div class="container11">
            <img class="icon12" src="icon11.svg" />
          </div>
          <div class="container12">
            <div class="_1-176-000">₱1,176,000</div>
          </div>
          <div class="container13">
            <div class="overdue">Overdue</div>
          </div>
        </div>
        <div class="container16">
          <div class="container11">
            <img class="icon13" src="icon12.svg" />
          </div>
          <div class="container12">
            <div class="_3">3</div>
          </div>
          <div class="container13">
            <div class="total-invoices">Total Invoices</div>
          </div>
        </div>
      </div>
      <div class="container17">
        <div class="container18">
          <div class="container19">
            <div class="container20">
              <img class="icon14" src="icon13.svg" />
            </div>
            <div class="container21">
              <div class="heading-3">
                <div class="exchange-rate-monitor">Exchange Rate Monitor</div>
              </div>
              <div class="paragraph">
                <div class="usd-to-local-currency">USD to Local Currency</div>
              </div>
            </div>
          </div>
          <div class="container22"></div>
          <div class="component-2">
            <div class="button7">
              <div class="auto-fetch-on">Auto-Fetch: ON</div>
            </div>
          </div>
        </div>
        <div class="container23">
          <div class="container24">
            <div class="paragraph">
              <div class="current-rate">Current Rate</div>
            </div>
            <div class="paragraph">
              <div class="_1-35-lc-usd">1.35 LC/USD</div>
            </div>
          </div>
          <div class="container25">
            <div class="paragraph">
              <div class="last-updated">Last Updated</div>
            </div>
            <div class="paragraph">
              <div class="_2-hours-ago">2 hours ago</div>
            </div>
          </div>
          <div class="container26">
            <div class="paragraph">
              <div class="update-source">Update Source</div>
            </div>
            <div class="paragraph">
              <div class="automated">Automated</div>
            </div>
          </div>
        </div>
        <div class="container27">
          <img class="icon15" src="icon14.svg" />
          <div class="container28">
            <div class="paragraph">
              <div class="threshold-alert">Threshold Alert</div>
            </div>
            <div class="paragraph2">
              <div class="exchange-rate-has-exceeded-threshold-below-1-30">
                Exchange rate has exceeded threshold (below 1.30).
                Dollar-denominated balances have been recalculated. Review
                pricing adjustments recommended.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="finance-table">
        <div class="table-header">
          <div class="table-row">
            <div class="header-cell">
              <div class="invoice-id">Invoice ID</div>
            </div>
            <div class="header-cell2">
              <div class="customer">Customer</div>
            </div>
            <div class="header-cell3">
              <div class="amount">Amount</div>
            </div>
            <div class="header-cell4">
              <div class="due-date">Due Date</div>
            </div>
            <div class="header-cell5">
              <div class="status">Status</div>
            </div>
            <div class="header-cell6">
              <div class="actions">Actions</div>
            </div>
          </div>
        </div>
        <div class="table-body">
          <div class="table-row2">
            <div class="table-cell">
              <div class="text12">
                <div class="inv-001">INV-001</div>
              </div>
            </div>
            <div class="table-cell2">
              <div class="text13">
                <div class="dr-sarah-johnson">Dr. Sarah Johnson</div>
              </div>
            </div>
            <div class="table-cell3">
              <div class="text14">
                <div class="_862-400">₱862,400</div>
              </div>
            </div>
            <div class="table-cell4">
              <div class="text15">
                <div class="dec-15-2025">Dec 15, 2025</div>
              </div>
            </div>
            <div class="table-cell5">
              <div class="text16">
                <div class="paid2">Paid</div>
              </div>
            </div>
            <div class="table-cell6">
              <div class="container29">
                <div class="button8">
                  <div class="record-payment">Record Payment</div>
                </div>
                <div class="button9">
                  <img class="icon16" src="icon15.svg" />
                </div>
              </div>
            </div>
          </div>
          <div class="table-row3">
            <div class="table-cell">
              <div class="text17">
                <div class="inv-002">INV-002</div>
              </div>
            </div>
            <div class="table-cell2">
              <div class="text18">
                <div class="michael-chen">Michael Chen</div>
              </div>
            </div>
            <div class="table-cell3">
              <div class="text19">
                <div class="_459-200">₱459,200</div>
              </div>
            </div>
            <div class="table-cell4">
              <div class="text20">
                <div class="dec-20-2025">Dec 20, 2025</div>
              </div>
            </div>
            <div class="table-cell5">
              <div class="text21">
                <div class="pending">Pending</div>
              </div>
            </div>
            <div class="table-cell7">
              <div class="container29">
                <div class="button8">
                  <div class="record-payment">Record Payment</div>
                </div>
                <div class="button9">
                  <img class="icon17" src="icon16.svg" />
                </div>
              </div>
            </div>
          </div>
          <div class="table-row4">
            <div class="table-cell">
              <div class="text22">
                <div class="inv-003">INV-003</div>
              </div>
            </div>
            <div class="table-cell2">
              <div class="text23">
                <div class="emily-rodriguez">Emily Rodriguez</div>
              </div>
            </div>
            <div class="table-cell3">
              <div class="text24">
                <div class="_1-176-0002">₱1,176,000</div>
              </div>
            </div>
            <div class="table-cell4">
              <div class="text25">
                <div class="nov-28-2025">Nov 28, 2025</div>
              </div>
            </div>
            <div class="table-cell5">
              <div class="text26">
                <div class="overdue2">Overdue</div>
              </div>
            </div>
            <div class="table-cell8">
              <div class="container29">
                <div class="button8">
                  <div class="record-payment">Record Payment</div>
                </div>
                <div class="button9">
                  <img class="icon18" src="icon17.svg" />
                </div>
              </div>
            </div>
          </div>
          <div class="table-row5">
            <div class="table-cell">
              <div class="text27">
                <div class="inv-004">INV-004</div>
              </div>
            </div>
            <div class="table-cell2">
              <div class="text28">
                <div class="david-park">David Park</div>
              </div>
            </div>
            <div class="table-cell3">
              <div class="text29">
                <div class="_700-000">₱700,000</div>
              </div>
            </div>
            <div class="table-cell4">
              <div class="text30">
                <div class="dec-25-2025">Dec 25, 2025</div>
              </div>
            </div>
            <div class="table-cell5">
              <div class="text21">
                <div class="pending">Pending</div>
              </div>
            </div>
            <div class="table-cell9">
              <div class="container29">
                <div class="button8">
                  <div class="record-payment">Record Payment</div>
                </div>
                <div class="button9">
                  <img class="icon19" src="icon18.svg" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
