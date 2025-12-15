@vite(['resources/css/sidebar.css'])
@vite(['resources/css/inventory.css'])
<div class="inventory-window">
  @include("components.sidebar")
  <div class="admin-inventory">
    <div class="container5">
      <div class="heading-1">
        <div class="inventory2">Inventory</div>
      </div>
    </div>
    <div class="container6">
      <div class="container7">
        <div class="container8">
          <div class="heading-2">
            <div class="inventory-dashboard">Inventory Dashboard</div>
          </div>
          <div class="container9">
            <div class="button5">
              <img class="icon8" src="icon7.svg" />
              <div class="aging-report">Aging Report</div>
            </div>
            <div class="button6">
              <img class="icon9" src="icon8.svg" />
              <div class="daily-scan-log">Daily Scan Log</div>
            </div>
            <div class="button7">
              <img class="icon10" src="icon9.svg" />
              <div class="record-stock-in">Record Stock In</div>
            </div>
            <div class="button8">
              <img class="icon11" src="icon10.svg" />
              <div class="record-stock-out">Record Stock Out</div>
            </div>
          </div>
        </div>
        <div class="inven-table">
          <div class="table-header">
            <div class="table-row">
              <div class="header-cell">
                <div class="item">Item</div>
              </div>
              <div class="header-cell2">
                <div class="quantity">Quantity</div>
              </div>
              <div class="header-cell3">
                <div class="location">Location</div>
              </div>
              <div class="header-cell4">
                <div class="status">Status</div>
              </div>
              <div class="header-cell5">
                <div class="actions">Actions</div>
              </div>
            </div>
          </div>
          <div class="table-body">
            <div class="table-row2">
              <div class="table-cell">
                <div class="text12">
                  <div class="portable-ultrasound-machine">
                    Portable Ultrasound Machine
                  </div>
                </div>
              </div>
              <div class="table-cell2">
                <div class="text13">
                  <div class="_15">15</div>
                </div>
              </div>
              <div class="table-cell3">
                <div class="container10">
                  <img class="icon12" src="icon11.svg" />
                  <div class="warehouse-a">Warehouse A</div>
                </div>
              </div>
              <div class="table-cell4">
                <div class="text14">
                  <div class="good-stock">Good Stock</div>
                </div>
              </div>
              <div class="table-cell5">
                <div class="button9">
                  <div class="update-location">Update Location</div>
                </div>
              </div>
            </div>
            <div class="table-row3">
              <div class="table-cell">
                <div class="text15">
                  <div class="patient-monitor">Patient Monitor</div>
                </div>
              </div>
              <div class="table-cell2">
                <div class="text16">
                  <div class="_3">3</div>
                </div>
              </div>
              <div class="table-cell3">
                <div class="container10">
                  <img class="icon13" src="icon12.svg" />
                  <div class="warehouse-b">Warehouse B</div>
                </div>
              </div>
              <div class="table-cell4">
                <div class="text17">
                  <div class="low-stock">Low Stock</div>
                </div>
              </div>
              <div class="table-cell5">
                <div class="button9">
                  <div class="update-location">Update Location</div>
                </div>
              </div>
            </div>
            <div class="table-row4">
              <div class="table-cell">
                <div class="text18">
                  <div class="surgical-instruments-set">
                    Surgical Instruments Set
                  </div>
                </div>
              </div>
              <div class="table-cell2">
                <div class="text19">
                  <div class="_8">8</div>
                </div>
              </div>
              <div class="table-cell3">
                <div class="container10">
                  <img class="icon14" src="icon13.svg" />
                  <div class="warehouse-c">Warehouse C</div>
                </div>
              </div>
              <div class="table-cell4">
                <div class="text14">
                  <div class="good-stock">Good Stock</div>
                </div>
              </div>
              <div class="table-cell5">
                <div class="button9">
                  <div class="update-location">Update Location</div>
                </div>
              </div>
            </div>
            <div class="table-row5">
              <div class="table-cell">
                <div class="text20">
                  <div class="digital-thermometer">Digital Thermometer</div>
                </div>
              </div>
              <div class="table-cell2">
                <div class="text21">
                  <div class="_0">0</div>
                </div>
              </div>
              <div class="table-cell3">
                <div class="container10">
                  <img class="icon15" src="icon14.svg" />
                  <div class="warehouse-a">Warehouse A</div>
                </div>
              </div>
              <div class="table-cell4">
                <div class="text22">
                  <div class="out-of-stock">Out of Stock</div>
                </div>
              </div>
              <div class="table-cell5">
                <div class="button9">
                  <div class="update-location">Update Location</div>
                </div>
              </div>
            </div>
            <div class="table-row6">
              <div class="table-cell">
                <div class="text23">
                  <div class="blood-pressure-monitor">
                    Blood Pressure Monitor
                  </div>
                </div>
              </div>
              <div class="table-cell2">
                <div class="text24">
                  <div class="_2">2</div>
                </div>
              </div>
              <div class="table-cell3">
                <div class="container10">
                  <img class="icon16" src="icon15.svg" />
                  <div class="warehouse-b">Warehouse B</div>
                </div>
              </div>
              <div class="table-cell4">
                <div class="text17">
                  <div class="low-stock">Low Stock</div>
                </div>
              </div>
              <div class="table-cell5">
                <div class="button9">
                  <div class="update-location">Update Location</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container11">
          <div class="container12">
            <div class="container13">
              <img class="icon17" src="icon16.svg" />
              <div class="container14">
                <div class="paragraph">
                  <div class="low-stock-alert">Low Stock Alert</div>
                </div>
                <div class="paragraph">
                  <div class="_2-items-below-threshold">
                    2 items below threshold
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container15">
            <div class="container13">
              <img class="icon18" src="icon17.svg" />
              <div class="container16">
                <div class="paragraph">
                  <div class="replenishment-alert">Replenishment Alert</div>
                </div>
                <div class="paragraph">
                  <div class="_3-items-need-restocking">
                    3 items need restocking
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container17">
        <div class="container18">
          <div class="heading-22">
            <div class="stock-transfer-workflow">Stock Transfer Workflow</div>
          </div>
          <div class="button10">
            <img class="icon19" src="icon18.svg" />
            <div class="new-transfer">New Transfer</div>
          </div>
        </div>
        <div class="container19">
          <div class="container20">
            <div class="container21">
              <div class="paragraph">
                <div class="patient-monitor2">Patient Monitor</div>
              </div>
              <div class="paragraph">
                <div class="warehouse-a-warehouse-b">
                  Warehouse A → Warehouse B
                </div>
              </div>
            </div>
            <div class="text25">
              <div class="completed">Completed</div>
            </div>
          </div>
          <div class="container20">
            <div class="container21">
              <div class="paragraph">
                <div class="surgical-instruments-set2">
                  Surgical Instruments Set
                </div>
              </div>
              <div class="paragraph">
                <div class="warehouse-b-warehouse-c">
                  Warehouse B → Warehouse C
                </div>
              </div>
            </div>
            <div class="text26">
              <div class="pending">Pending</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
