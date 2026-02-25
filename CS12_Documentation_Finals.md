# RozMed Enterprises Inc. Management System

**College of Computing Education**  
**University of Mindanao**

## Course Requirement
**CS12L Software Engineering 1**  
**Major Project Compiled Documentation**

### Submitted By
- Mantua, Gabriel T.
- Picardal, Liea Maegan C.
- Pintor, Tristhan Alfie

### Submitted To
Ms. Feranz Salonga  
December 2025

---

## Table of Contents

1. [MILESTONE 1](#milestone-1)
2. [MILESTONE 2](#milestone-2)
3. [MILESTONE 3](#milestone-3)
4. [MILESTONE 4](#milestone-4)
5. [MILESTONE 5](#milestone-5)
6. [MILESTONE 6](#milestone-6)
7. [MILESTONE 7 - Entity Relationship Diagram](#milestone-7---entity-relationship-diagram)
8. [MILESTONE 8 - Laravel Subsystem Build](#milestone-8---laravel-subsystem-build)
9. [MILESTONE 9 - Functional Test Case](#milestone-9---functional-test-case)
10. [MILESTONE 10 - Figma Design](#milestone-10---figma-design)
11. [MILESTONE 11 - Non-Functional Test Case/Evaluation Report](#milestone-11---non-functional-test-caseevaluation-report)
12. [References](#references)

---

# MILESTONE 1

The Rozmed Enterprise Inc is a medical and laboratory equipment supplier that has been in existence for a considerable period. The company operates as a marketing company with a lean organizational structure that has a total of five employees.

## FINANCIAL OVERVIEW

![Figure 1. Sample Revenue Graph]

**Expected Annual Revenue:** 10-15 million pesos

**Revenue Reality:** The company acknowledges that higher revenue doesn't always equate to higher profit margins.

**Quotation-to-Sales Ratio:** Out of 150-200 quotations given annually, only 11-15 typically convert to actual sales.

**Payment Terms:** Flexible arrangements including 6 months to 2 years payment plans.

## EXISTING SYSTEM

### Manual Records
The company operates using a fully manual record-keeping system. All documentation is maintained without digital backup or automation.

### Obsolete Tech
The company previously utilized an automated inventory system, but it is no longer in use. Currently, all operations are conducted manually.

### No Online Presence
The operation relies on a Facebook page, however it is not regularly updated and no functional website exists.

### Payment Methods
Payment methods are stored manually through hardcopy drives. The organization accepts payment through various channels including bank transfers, checks, and GCash.

## SWOT ANALYSIS

**Table 1. SWOT Analysis**

| Strengths (S) | Weaknesses (W) |
|---------------|----------------|
| Direct Importation & Supplier Relationships | No Digital Management System |
| Experienced Team | Limited Online Presence |
| Flexible Payment Terms | Manual Record-Keeping |
| Established Customer Base | Obsolete Technology Infrastructure |

| Opportunities (O) | Threats (T) |
|-------------------|-------------|
| Digital Transformation | Increasing Competition |
| Market Expansion | Technology Disruption |
| Process Automation | Customer Expectations |
| Enhanced Customer Experience | Market Volatility |

## PROPOSED SYSTEM

### Product Catalog
This system features a dynamic product display organized by category, complete with images and detailed specifications to facilitate customer browsing and selection.

### Inventory System
This system monitors real-time stock levels, sales, and aging inventory through automated alerts. The system tracks product movement across multiple locations.

### Customer Management
This system serves as the primary point of contact for customer inquiries, documenting all interactions and maintaining comprehensive customer profiles.

### Finance System
The system manages long-term payment schedules spanning up to two years. It also lists all transactions, generates invoices, and tracks payment status.

## FUNCTIONAL OBJECTIVES

- **Dashboard:** Provides a visual overview of business activities and metrics for quick decision-making.
- **Product Catalog:** Allow users to browse, search, and view detailed information on all available products.
- **Stock Monitoring:** Tracks inventory levels and records all sales, acquisitions, and inter-location transfers.
- **Add Customer Information:** Creates and maintains a centralized database of client and prospect client details.
- **Log Customer Communication:** Records all interactions with customers to maintain a complete history and support follow-ups.
- **Create Quotation:** Generates formal, customizable price proposals for products or services to send to customers.
- **Generate Invoice:** Generate official payment requests and receipts based on completed sales or approved quotations.
- **Create Payment Plans:** Create multi-installment schedules for customers to pay off an invoice over time.
- **Upload Documents:** Stores and organizes digital files of certificates.
- **Manage Templates:** Create, update and edit layout and standard content for reusable documents like quotations.

## NON-FUNCTIONAL OBJECTIVES

- **Usability** - Intuitive, mobile-friendly, and easy to navigate for users of all technical levels.
- **Security** - Basic SSL certificate and regular updates to protect the site and build user trust.
- **Performance** - Fast loading times (under 3 seconds) to prevent potential customers from leaving.
- **Maintainability** - Built on a stable, common platform for easy, low-cost future updates.

---

# MILESTONE 2

## Case Study Overview

Milestone 2 is a formal case study submission that will serve as your second written examination for this course.

### Business Activities (Professional Operating Procedures)

**Business Activities & Event Table**

- **C — Client/Guest:** Review and check available equipment.
- **S — Staff:** Employees are responsible for the day-to-day operations, reviews, and answer inquiries.
- **O — Owner:** Ensure compliance with laws, taxes, and regulations.
- **M — Manager:** Manage the day-to-day operations and staff.

### The Event

**Column definitions (reading guide):**
- **Event** — A concise, business-meaningful description of what occurs
- **Trigger** — The condition that initiates the event
- **Source** — The originator of the trigger (e.g., Client, Admin)
- **Activity** — The processing performed in response
- **Response** — The business outcome and artifact(s) produced
- **Destination** — The intended recipient(s) of the response or the data store updated

## Product Catalog System

RozMED Enterprises Inc. online marketing is primarily through Facebook; however, the page appears to be dormant with minimal engagement.

The vision is to significantly expand the sales market, where customers can effortlessly navigate products, review specifications, and submit inquiries digitally.

To easily implement the project, it is assumed that clients have reliable internet access and possess basic digital literacy.

Moreover, the project faces constraints. The model is not a direct e-commerce platform as it is limited to showcasing products and collecting inquiries.

The main stakeholders of the Product Catalog System are staff, clients, and the owner, who also acts as the manager.

The success of the Product Catalog System (PCS) will be rigorously measured against predefined Key Performance Indicators.

### Product Catalog Features
- View products and specifications
- Inquiry submission
- Update content/product details
- Create content and product details
- Remove product
- Search specific products

### Product Catalog Event Table

**Table 2. Product Catalog System Event Table**

| EVENT | TRIGGER | SOURCE | ACTIVITY | RESPONSE | DESTINATION |
|-------|---------|--------|----------|----------|-------------|
| View product and product specifications | Client/Guest navigates and requests product info | Client | Check products | Display equipment photo, specifications, pricing | Client's UI |
| Inquiry submission | Client submits an inquiry form | Client | Submit inquiry | Display inquiry receipt | Database, Client's UI |
| Update content/product details | Admin modifies product information | Admin/Staff | Update database | Confirmation message, updated catalog | Database, Product Catalog |
| Create content and product details | Admin adds new product | Admin/Staff | Add to database | New product displayed | Database, Product Catalog |
| Remove product | Admin deletes product | Admin/Staff | Remove from database | Confirmation message | Database, Product Catalog |
| Search specific products | Client enters search query | Client | Query database | Display matching products | Client's UI |

## Inventory Management System

RozMed currently manages its inventory manually. While they previously utilized electronic inventory management, the system has since been discontinued.

The system impacts the management as it provides real-time visibility of stocks and their movement across multiple locations.

The project operates under several key assumptions and constraints. A primary assumption is that all staff members will receive adequate training on the new system.

The project faces constraints, which include that the staff are more comfortable with the manual inventory system and may resist digital adoption.

The system must fulfill several non-functional requirements that define its quality and effectiveness.

### Inventory Management Features
- Stock In (Receive Inventory)
- Stock Out (Dispatch Inventory)
- Product Replenishment Alert
- Track Aging Inventory
- Transfer Inventory
- Update Product Location

### Inventory Management Event Table

**Table 3. Inventory Management Event Table**

| EVENT | TRIGGER | SOURCE | ACTIVITY | RESPONSE | DESTINATION |
|-------|---------|--------|----------|----------|-------------|
| Stock In (Receive Inventory) | New stock is received from a supplier | Receiving Dept./Admin | Record received quantities, update inventory | Inventory levels are incremented | Database, Inventory Management Dashboard |
| Stock Out (Dispatch Inventory) | A sale is finalized, or items are transferred out | Sales System/Admin | Record the items and quantities dispatched | Inventory levels are updated in real-time | Database, Inventory Management Dashboard |
| Product Replenishment Alert | Stock level falls below threshold | System (Automated) | Generate low-stock alert | Email/notification sent to admin | Admin Dashboard, Email |
| Track Aging Inventory | Scheduled scan (daily/weekly) | System (Automated) | Identify items nearing expiration or slow-moving | Aging report generated | Admin Dashboard, Reports |
| Transfer Inventory | Inter-branch transfer request | Admin/Manager | Update stock levels at both locations | Transfer confirmation, updated inventory | Database, Both Locations |
| Update Product Location | Item moved within facility | Staff/Admin | Update storage location in system | Location updated in database | Database, Inventory Dashboard |

## Customer Management (CM)

RozMed faces a critical operational deficiency in its sales process: lack of a centralized digital tracking system for customer information and communication history.

The comprehensive CM aims to consolidate contact information, communication history, and analyse conversion patterns.

The system impacts stakeholders, primarily customers and staff. For the customer, the CM will streamline their experience with faster response times and personalized service.

A primary assumption is that potential and existing customers possess access to digital communication channels such as email and mobile phones.

The system's constraints include the fundamental requirement to integrate seamlessly with existing communication channels without disrupting current workflows.

The system must exhibit high performance by supporting user interactions with a 2-second response time for all queries.

### Customer Management Features
- Add a new customer
- Create quotation
- Manage quotation-to-sale pipeline
- Schedule follow-up
- Log customer interactions

### Customer Management Event Table

**Table 4. Customer Management Event**

| EVENT | TRIGGER | SOURCE | ACTIVITY | RESPONSE | DESTINATION |
|-------|---------|--------|----------|----------|-------------|
| Add a New Customer | Admin clicks "Add Customer" after initial contact | Sales/Admin | Create a new customer profile with details | Customer record created and displayed | Database, CM Dashboard |
| Create Quotation | A sales opportunity is identified | Sales/Admin | Generate a new quotation linked to customer | Quotation created in "Draft" status | Document System, CM Pipeline |
| Manage quotation-to-sale pipeline | Admin reviews pipeline stages | Sales/Admin | Update quotation status, track progress | Pipeline view updated with current stages | CM Dashboard, Reports |
| Schedule follow-up | Quotation requires follow-up | Sales/Admin | Set reminder date and notes | Follow-up task created | Database, Calendar, Notifications |
| Log customer interactions | Communication occurs with customer | Sales/Admin | Record call, email, or meeting notes | Interaction logged with timestamp | Database, Customer Profile |

## Financial Management & Payment Tracking System

One of the most critical workflows is managing financial agreements and multi-channel receivables. RozMed faces challenges in tracking payment schedules and monitoring outstanding balances.

The system stakeholders involved are the staff, manager, owner, and existing client. The staff are responsible for recording payments and generating invoices.

The system is under several assumptions and constraints. It is assumed that a real-time data source for exchange rates will be available and accessible.

The operational constraints must also be meticulously considered. The system must comply with all relevant financial regulations and tax requirements.

The key non-functional requirements for a financial management and payment tracking system that define its quality and effectiveness include accuracy, security, and auditability.

### Financial Management & Payment Tracking Features
- Create payment plan
- Generate and print invoice
- Record payment
- Check for due dates
- Monitor exchange rates

### Financial Management & Payment Tracking Event Table

**Table 5. Financial Management & Payment Tracking Event Table**

| EVENT | TRIGGER | SOURCE | ACTIVITY | RESPONSE | DESTINATION |
|-------|---------|--------|----------|----------|-------------|
| Create Payment Plan | A sale is finalized with extended payment terms | Sales/Admin | Define payment schedule (installments, dates, amounts) | Payment plan created and linked to customer | Database, Customer Financial Profile |
| Generate & Print Invoice | A sale is approved or a payment is due | Sales System/Admin | Create a professional invoice with payment details | Invoice generated; displayed on-screen or printed | Database, Document System, Customer |
| Record Payment | Customer makes a payment via any channel | Finance Staff/Admin | Validate and record payment, update balance | Outstanding balance updated, receipt issued | Database, Payment History, Customer |
| Check for Due Dates | Scheduled system scan (daily) | System (Automated) | Identify upcoming or overdue payments | Reminder notifications sent to staff and customer | Admin Dashboard, Email, SMS |
| Monitor Exchange Rates | Scheduled API call or manual update | System/Finance Staff | Fetch current exchange rates for foreign transactions | Exchange rates updated in system | Database, Invoice Generation Module |

## Document Management System

The operation handles documents manually, resulting in operational inefficiencies, the risk of data loss, and version control challenges.

The key system stakeholders include the staff, manager, and owner. The staff will be responsible for creating, editing, and organizing documents daily.

The project operates under several key assumptions and constraints. Staff and administrative users are assumed to have basic computer literacy and familiarity with document management workflows.

The project is subject to several key constraints. The system must enforce security protocols, including role-based access control to ensure sensitive documents are only accessible to authorized personnel.

The documentation management system must be highly functional and fulfill several critical non-functional requirements including reliability, scalability, and usability.

### Document Management Features
- Generate new quotation
- Store quotation with version control (Revise)
- Track quotation status
- Manage supporting documents
- Create/edit standardized template

### Document Management Event Table

**Table 6. Document Management Event Table**

| EVENT | TRIGGER | SOURCE | ACTIVITY | RESPONSE | DESTINATION |
|-------|---------|--------|----------|----------|-------------|
| Generate New Quotation | Salesperson needs to create a quotation | Sales/Admin | Select a template and input product/pricing details | A professional quotation document is created | Database, System UI (for download/email) |
| Store Quotation with Version Control | Customer requests changes or admin revises quotation | Sales/Admin | Modify an existing quotation | New version is saved; previous versions archived | Database (with version history) |
| Track Quotation Status | Admin checks quotation progress | Sales/Admin | View quotation lifecycle (draft, sent, accepted, rejected) | Status displayed with timeline | Document Management Dashboard |
| Manage Supporting Documents | Staff uploads certificates, compliance docs, or attachments | Staff/Admin | Upload, categorize, and link documents to products/quotations | Documents stored securely and linked to relevant records | Database, Document Repository |
| Create/Edit Standardized Template | Admin needs to update quotation format or branding | Admin/Manager | Design or modify templates with placeholders | Updated template saved and available for use | Database, Template Library |

---

# MILESTONE 3

## RETURN ON INVESTMENT

### Cost-Benefit Analysis

**Table 7. Cost-Benefit Analysis Table (Year 0)**

| CATEGORY | DESCRIPTION | PHP |
|----------|-------------|-----|
| Personnel | 1 Back end Developer (4 months) | 120,000 |
| Personnel | 1 Front-end Developer (3 months) | 75,000 |
| Infrastructure | Domain registration | 500 |
| Infrastructure | Hosting (1 year) | 7,000 |
| Software | Laravel framework | 0 |
| Software | MySQL database | 0 |
| Software | Development tools | 0 |
| Testing | Quality assurance | 15,000 |
| Deployment | Initial setup and configuration | 5,000 |
| Training | Staff training (2 sessions) | 10,000 |
| Documentation | Technical and user documentation | 8,000 |
| Contingency | 10% buffer | 24,048 |
| **TOTAL YEAR 0** | | **₱264,548** |

### Year 1

**Table 8. Cost-Benefit Analysis Table (Year 1)**

| CATEGORY | DESCRIPTION | TOTAL |
|----------|-------------|-------|
| Personnel (Maintenance) | 1 Front-end Support (1 month) | 25,000 |
| Personnel (Maintenance) | 1 Back end support | 30,000 |
| Annual Operational Costs | Hosting renewal | 7,000 |
| Annual Operational Costs | Domain renewal | 500 |
| Annual Operational Costs | SSL certificate | 2,500 |
| Updates | Feature enhancements | 15,000 |
| Support | Technical support | 20,000 |
| Monitoring | System monitoring tools | 5,000 |
| Security | Security updates and patches | 10,000 |
| Backup | Data backup services | 5,000 |
| **TOTAL YEAR 1** | | **₱120,000** |

### Year 2

**Table 9. Cost-Benefit Analysis Table (Year 2)**

| CATEGORY | DESCRIPTION | TOTAL |
|----------|-------------|-------|
| Annual Operational Costs | Hosting renewal | 7,000 |
| Annual Operational Costs | Domain renewal | 500 |
| Annual Operational Costs | SSL certificate | 2,500 |
| Updates | Feature enhancements | 15,000 |
| Support | Technical support | 20,000 |
| Monitoring | System monitoring tools | 5,000 |
| Security | Security updates and patches | 10,000 |
| Backup | Data backup services | 5,000 |
| **TOTAL YEAR 2** | | **₱65,000** |

## Annual Benefits Estimate for RozMED Management System

### Increased Revenue

**Year 1:**

It is assumed that the implementation of robust management systems frequently yields substantial financial returns. Based on industry research, companies implementing comprehensive management systems experience revenue growth of 20-30% within the first year.

- **Current Annual Sales:** ₱15,000,000
- **Estimated Additional Revenue:** ₱4,500,000

**Year 2:**

Assumption of 35% more sales due to efficiency, and strong online presence making RozMED easy to find and engage with.

- **Current Annual Sales:** ₱15,000,000
- **Estimated Additional Revenue:** ₱5,250,000

### Labor Costing

**Year 1:**

It is assumed that the implementation of management systems saves around 10% to 15% of workforce costs due to automation of repetitive tasks.

- **Current Annual Admin Costs:** ₱149,076
- **Estimated Savings:** ₱14,907.6

**Year 2 and Beyond:** Assumption of 15% reduction.
- **Estimated Savings:** ₱22,361.4

### Operational Efficiency

**Year 1:**

It is assumed that office supply consumption will reduce by about 70% by integrating the management system, reducing paper-based documentation.

- **Current Annual Expense on office supplies:** ₱150,000
- **Estimated Savings:** ₱105,000

**Year 2 and Beyond:**

Assumption of 75% with lessen the office supplies use.
- **Estimated Savings:** ₱112,500

The RozMED management system will reduce errors in manual inventory, decrease expenses in office supplies, and improve operational workflow efficiency.

## Summary of Estimated Annual Benefits

### Year 1

**Table 10. Summary of Estimated Annual Benefits (Year 1)**

| CATEGORY | DESCRIPTION | PHP |
|----------|-------------|-----|
| Annual Benefits | Increased Revenue | 4,500,000 |
| | Labor Cost Saving | 14,907.6 |
| | Operational Efficiency | 105,000 |
| | Error Reduction | 20,000 |
| | Improved Customer Experience | 50,000 |
| | Time Savings | 64,168.4 |
| **TOTAL YEAR 1 BENEFITS** | | **₱4,754,076** |

### Year 2 and Beyond

**Table 11. Summary of Estimated Annual Benefits (Year 2)**

| CATEGORY | DESCRIPTION | PHP |
|----------|-------------|-----|
| Annual Benefits | Increased Revenue | 5,250,000 |
| | Labor Cost Saving | 22,361.4 |
| | Operational Efficiency | 112,500 |
| **TOTAL YEAR 2+ BENEFITS** | | **₱5,384,862.4** |

## Return on Investment (ROI) Estimate for RozMED Enterprises Inc. Management System

### Total Project Cost (One-time Implementation Cost):
- **Total Development Cost:** ₱523,480

### Annual Costs:
- **Year 1:** ₱120,000
- **Year 2 and beyond:** ₱65,000

### Annual Benefits (Estimated):
- **Year 1:** ₱4,754,076
- **Year 2:** ₱5,384,862.4

**Table 12. Return on Investment (ROI)**

| Year | Annual Benefits | Annual Cost | Net Benefits | Cumulative Net Benefits | Total Investment | ROI(%) |
|------|----------------|-------------|--------------|------------------------|------------------|--------|
| 0 | 0 | -523,480 | -523,480 | -523,480 | 523,480 | - |
| 1 | 4,754,076 | 120,000 | 4,634,076 | 4,110,596 | 643,480 | 785.2 |
| 2 | 5,384,862.4 | 65,000 | 5,319,862.4 | 9,430,458.4 | 708,480 | 1431.1 |

![Figure 2. Net Benefits and Total Investment Graph]

The provided ROI table and graph visually compare the Total Investment against the Cumulative Benefits over a two-year period. Initially, Year 0 shows the upfront investment cost of ₱523,480 with no immediate returns, resulting in a negative cumulative position.

By Year 2, the gap between the cumulative benefits and total investment widens substantially, reflecting the compounding effect of sustained revenue growth, cost savings, and operational improvements.

---

# MILESTONE 4

## Product Catalog Case Diagram

The Product Catalog System enables clients to browse products, view specifications, and submit inquiries, while administrators manage the catalog by adding, updating, or removing products.

**Key Use Cases:**
- Browse Products
- View Product Specifications
- Submit Inquiry
- Manage Product Catalog (Admin)
- Update Product Details (Admin)
- Create New Product (Admin)
- Remove Product (Admin)
- Search Products

![Figure 3. Product Catalog Case Diagram]

## Inventory Management Case Diagram

The Inventory Management System tracks stock movements, monitors inventory levels, generates alerts for low stock and aging inventory, and manages transfers between locations.

**Key Use Cases:**
- Record Stock In
- Record Stock Out
- View Inventory Dashboard
- Generate Stock Alerts
- Track Aging Inventory
- Transfer Inventory Between Locations
- Update Product Location
- Generate Inventory Reports

![Figure 4. Inventory Management Case Diagram]

## Customer Management Case Diagram

The Customer Management System centralizes customer information, tracks interactions, manages the quotation pipeline, and schedules follow-ups.

**Key Use Cases:**
- Add New Customer
- Update Customer Information
- Create Quotation
- Manage Quotation Pipeline
- Schedule Follow-up
- Log Customer Interaction
- View Customer History
- Search Customers

![Figure 5. Customer Management Case Diagram]

## Financial Management & Payment Tracking System

The Financial Management System handles payment plans, invoice generation, payment recording, due date monitoring, and exchange rate tracking.

**Key Use Cases:**
- Create Payment Plan
- Generate Invoice
- Print Invoice
- Record Payment
- Monitor Payment Due Dates
- Track Exchange Rates
- View Payment History
- Generate Financial Reports

![Figure 6. Financial Management & Payment Tracking System]

## Document Management Case Diagram

The Document Management System manages quotation templates, tracks document versions, stores supporting documents, and maintains document workflow.

**Key Use Cases:**
- Generate New Quotation
- Store Quotation with Version Control
- Track Quotation Status
- Upload Supporting Documents
- Create/Edit Templates
- View Document History
- Search Documents

![Figure 7. Document Management Case Diagram]

## FULLY DEVELOPED USE CASE DESCRIPTIONS

### Fully Developed Use Case 1: Product Catalog System

**Table 13. Fully Developed Use Case of Product Catalog System**

| Field | Description |
|-------|-------------|
| **Use Case Name:** | Product Catalog Management |
| **Triggered Event:** | Client or Admin performs product-related action |
| **Actors** | Client/Guest, Admin |
| **Brief Description** | Allows clients to browse and search for products, and administrators to manage the product catalog |
| **Preconditions** | - System is operational<br>- Product database is accessible<br>- Admin is authenticated (for management functions) |
| **Postconditions** | - Product information is displayed or updated<br>- Inquiries are recorded<br>- Catalog changes are saved |
| **Normal Flow** | 1. Client accesses product catalog<br>2. System displays products by category<br>3. Client can search or filter products<br>4. Client views product details and specifications<br>5. Client submits inquiry form (optional)<br>6. System records inquiry and sends confirmation |
| **Alternative Flows** | **Admin Flow:**<br>1. Admin logs into system<br>2. Accesses product management interface<br>3. Adds/edits/removes products<br>4. Uploads product images and specifications<br>5. System validates and saves changes<br>6. Updated catalog is published |
| **Exception Flows** | - No products match search criteria<br>- Image upload fails<br>- Invalid product data entered<br>- Database connection error |

### Fully Developed Use Case 2: Inventory Management

**Table 14. Fully Developed Use Case of Inventory Management**

| Field | Description |
|-------|-------------|
| **Use Case Name:** | Inventory Management |
| **Triggered Event:** | Stock received, stock dispatched, or inventory query |
| **Actors** | Admin, Staff, Receiving Dept., System (Automated) |
| **Brief Description** | Tracks inventory levels, records stock movements, generates alerts, and manages multi-location inventory |
| **Preconditions** | - User is authenticated<br>- Inventory database is accessible<br>- Product records exist |
| **Postconditions** | - Stock levels are updated<br>- Movement records are logged<br>- Alerts are generated if thresholds met |
| **Normal Flow** | **Stock In:**<br>1. Receiving dept. records new stock arrival<br>2. System prompts for product, quantity, supplier<br>3. User enters data and confirms<br>4. System updates inventory levels<br>5. Receipt is generated |
| **Alternative Flows** | **Stock Out:**<br>1. Sale or transfer is processed<br>2. System deducts quantities<br>3. Updates inventory levels<br>4. Generates dispatch record<br><br>**Transfer:**<br>1. Admin initiates transfer between locations<br>2. System updates both locations<br>3. Transfer log is created |
| **Exception Flows** | - Insufficient stock for dispatch<br>- Invalid product code<br>- Duplicate entry detected<br>- System generates low-stock alert |

### Fully Developed Use Case 3: Customer Management (CM)

**Table 15. Fully Developed Use Case of Customer Management (CM)**

| Field | Description |
|-------|-------------|
| **Use Case Name:** | Customer Management |
| **Triggered Event:** | Staff adds customer, generates quotation, or logs interaction |
| **Actors** | Staff, Admin, System (Automated reminders) |
| **Brief Description** | Manages customer information, tracks quotation pipeline, schedules follow-ups, and logs all interactions |
| **Preconditions** | - User is authenticated<br>- Customer database is accessible |
| **Postconditions** | - Customer records are created/updated<br>- Quotations are tracked<br>- Interactions are logged |
| **Normal Flow** | 1. Staff clicks "Add New Customer"<br>2. Enters customer details (name, institution, contact)<br>3. System validates and saves record<br>4. Staff creates quotation linked to customer<br>5. System tracks quotation in pipeline<br>6. Staff schedules follow-up reminder<br>7. System sends notification on due date |
| **Alternative Flows** | **Log Interaction:**<br>1. Staff selects customer<br>2. Clicks "Log Interaction"<br>3. Enters communication details<br>4. System timestamps and saves<br>5. Interaction appears in customer timeline |
| **Exception Flows** | - Duplicate customer detected<br>- Required fields missing<br>- Invalid contact information<br>- Quotation template not found |

### Fully Developed Use Case 4: Financial Management & Payment Tracking

**Table 16. Fully Developed Use Case of Financial Management & Payment Tracking**

| Field | Description |
|-------|-------------|
| **Use Case Name:** | Financial Management & Payment Tracking |
| **Triggered Event:** | Admin actions or automated system scans |
| **Actors** | Admin, Finance Staff, System (Automated) |
| **Brief Description** | Manages payment plans, generates invoices, records payments, and monitors due dates |
| **Preconditions** | - User is authenticated<br>- Customer has an active account<br>- Sale is finalized (for payment plan) |
| **Postconditions** | - Payment plan/invoice created<br>- Payment recorded<br>- Balances updated<br>- Notifications sent |
| **Normal Flow** | **Create Payment Plan:**<br>1. Admin finalizes sale with extended terms<br>2. Clicks "Create Payment Plan"<br>3. Defines installments, dates, amounts<br>4. System validates schedule<br>5. Payment plan is saved and linked to customer<br><br>**Generate Invoice:**<br>1. System or admin triggers invoice generation<br>2. Invoice is created with payment details<br>3. PDF is generated for download/email<br>4. Invoice number is assigned |
| **Alternative Flows** | **Record Payment:**<br>1. Customer makes payment<br>2. Finance staff enters payment details<br>3. System validates amount and method<br>4. Updates outstanding balance<br>5. Receipt is issued<br><br>**Check Due Dates:**<br>1. System scans daily for upcoming payments<br>2. Generates reminder notifications<br>3. Sends to staff and customer |
| **Exception Flows** | - Invalid payment amount<br>- Payment plan exceeds limit<br>- Invoice generation fails<br>- Exchange rate API unavailable |

### Fully Developed Use Case 5: Document Management

**Table 17. Fully Developed Use Case of Document Management**

| Field | Description |
|-------|-------------|
| **Use Case Name:** | Document Management |
| **Triggered Event:** | Staff or Admin performs document-related action |
| **Actors** | Staff, Admin, Manager, System |
| **Brief Description** | Manages quotation generation, version control, template management, and supporting documents |
| **Preconditions** | - User is authenticated<br>- Templates exist in system<br>- Document repository is accessible |
| **Postconditions** | - Documents are generated/stored<br>- Versions are tracked<br>- Templates are updated |
| **Normal Flow** | **Generate Quotation:**<br>1. Salesperson clicks "New Quotation"<br>2. Selects template and customer<br>3. Inputs product details and pricing<br>4. System populates template<br>5. Preview is shown<br>6. Quotation is saved with unique ID<br>7. PDF is generated for download/email |
| **Alternative Flows** | **Version Control:**<br>1. Admin opens existing quotation<br>2. Makes revisions<br>3. Clicks "Save as New Version"<br>4. System archives previous version<br>5. New version is assigned incremental number<br><br>**Template Management:**<br>1. Admin accesses template library<br>2. Creates/edits template<br>3. Defines placeholders for dynamic data<br>4. Saves template<br>5. Template becomes available for use |
| **Exception Flows** | - Template not found<br>- Invalid data in quotation<br>- PDF generation fails<br>- Document upload exceeds size limit<br>- Version conflict detected |

---

# MILESTONE 5

## DATA DICTIONARY

### Entities

| Entity | Alias | Short Description | Input Flows | Output Flows |
|--------|-------|-------------------|-------------|--------------|
| **CUSTOMER** | Client, Institution | Healthcare institutions purchasing medical equipment | • Quotation Requests<br>• Purchase Orders<br>• Payment Data | • Quotation Receipt<br>• Order Confirmations<br>• Payment Receipts |
| **USER** | Employee, Staff | System users with roles (Sales, Admin, Manager) | • Login Credentials<br>• Activity Logs | • System Access<br>• Processed Transactions |
| **PRODUCT** | Equipment, Item | Medical/laboratory equipment in catalog | • Product Data<br>• Specifications<br>• Images | • Catalog Display<br>• Quotation Items<br>• Inventory Records |
| **QUOTATION** | Quote, Proposal | Formal price proposals to customers | • Product Selection<br>• Pricing Data<br>• Customer Info | • PDF Document<br>• Pipeline Status<br>• Conversion Data |
| **INVOICE** | Bill, Receipt | Payment request documents | • Sale Data<br>• Payment Terms | • PDF Document<br>• Payment Record |

### Data Flows

| Flow Label | Description | Origin | Destination | Est. Volume/Frequency |
|------------|-------------|--------|-------------|----------------------|
| **QUOTATION CREATION** | Customer requests quote → Sales creates proposal | CUSTOMER → FRONT_DESK | QUOTATION | ~50-100/day |
| **QUOTATION APPROVAL** | Sales reviews/approves quotation | FRONT_DESK | QUOTATION (status update) | Per quotation created |
| **STOCK MOVEMENT** | Inventory transactions (in/out/transfer) | WAREHOUSE/SALES | INVENTORY | ~20-50/day |
| **PAYMENT RECORDING** | Customer payment received and logged | CUSTOMER/BANK | PAYMENT_RECORD | ~10-15/day |
| **ALERT GENERATION** | System-generated notifications (low stock, due dates) | SYSTEM | ADMIN/STAFF | As triggered |
| **CUSTOMER INTERACTION LOG** | Communication record (call, email, meeting) | STAFF | CUSTOMER_RECORD | ~30-60/day |

### Data Stores

| Data Store Name | Alternative Name | Description | Key Attributes | Volume and Frequency |
|-----------------|------------------|-------------|----------------|---------------------|
| **CUSTOMER_MASTER** | Client Database | Stores customer institutions, contacts, segmentation | Customer_ID (PK), Institution_Name, Contact_Person, Email, Phone, Type, Status | ~2,000-5,000 records; updated daily |
| **PRODUCT_CATALOG** | Equipment Master | Product specifications, pricing, images, categories | Product_ID (PK), Product_Name, Category, Description, Price, Image_URL, Stock_Status | ~500-1,000 products; updated weekly |
| **INVENTORY** | Stock Database | Real-time stock levels across all locations | Inventory_ID (PK), Product_ID (FK), Location, Quantity, Last_Updated, Reorder_Level | ~1,000-2,000 records; updated hourly |
| **QUOTATION_REPOSITORY** | Quote Archive | All quotations with versions and status | Quotation_ID (PK), Customer_ID (FK), Date, Status, Version, Total_Amount, PDF_Path | ~150-200/month; archived yearly |
| **PAYMENT_RECORDS** | Transaction Log | Payment history and outstanding balances | Payment_ID (PK), Invoice_ID (FK), Customer_ID (FK), Amount, Date, Method, Currency | ~120-180/month; retained indefinitely |
| **DOCUMENT_LIBRARY** | File Repository | Supporting documents (certificates, compliance) | Document_ID (PK), Type, Upload_Date, File_Path, Linked_Entity | ~50-100 uploads/month |

### Processes

| Process Number | Process Name | Input Data Flows | Output Data Flows |
|----------------|--------------|------------------|-------------------|
| **1.0** | PRODUCT CATALOG MANAGEMENT | Search Keywords, Inquiry Form Data, Product Data | Product List Display, Inquiry Receipt, Updated Catalog |
| **2.0** | INVENTORY STOCK MANAGEMENT | New Stock Data, Sale/Transfer Data, Stock Query | Stock Level Updates, Transfer Records, Alerts |
| **3.0** | CUSTOMER RELATIONSHIP MANAGEMENT | Customer Data, Interaction Logs, Quotation Requests | Customer Records, Quotations, Follow-up Reminders |
| **4.0** | FINANCIAL MANAGEMENT | Payment Plan Data, Payment Records, Invoice Data | Invoices, Payment Receipts, Due Date Alerts |
| **5.0** | DOCUMENT MANAGEMENT | Template Data, Quotation Data, Document Uploads | Generated Documents, Version History, Status Updates |

## PROCESS DESCRIPTIONS

### Process 1.1 – Browse And Search Products
Receive search keywords from customers. Query product database for matching items. Display results with images, specifications, and pricing. Filter by category if specified. Return empty result with suggestion if no matches found.

### Process 1.2 – Submit Product Inquiry
Customer submits inquiry form with product interest. Validate required fields. Save inquiry to database with timestamp. Send confirmation email to customer. Notify sales team via dashboard alert. Create customer lead record if new.

### Process 1.3 – Manage Product Catalog
Admin adds/edits/removes products. Validate product data and images. Update product database. Refresh catalog cache. Log administrative action. Publish changes to live catalog immediately.

### Process 2.1 – Record Stock Movement
Record stock in (from suppliers/transfers) or stock out (from sales/transfers). Update inventory levels in real-time. Generate movement record with timestamp, user, and reason. Trigger low-stock alert if threshold crossed. Update product availability status.

### Process 2.2 – Monitor Stock Levels & Aging
Automated process scanning inventory for low stock thresholds and aging items. Flag items requiring attention. Generate reports for management review. Send email alerts to relevant personnel. Update dashboard metrics.

### Process 2.3 – MANAGE MULTI-LOCATION INVENTORY
Process inter-branch transfer requests. Update stock levels at both source and destination locations. Create transfer documentation. Track transfer status. Confirm receipt at destination. Maintain audit trail of movements.

### Process 3.1 – Manage Customer Information
Create/update customer profiles with contact details, institution type, and segmentation. Validate data completeness. Store in customer master database. Enable search and filtering. Maintain customer interaction history.

### Process 3.2 – Handle Quotation Pipeline
Create new quotations from templates. Update quotation status through workflow stages. Track conversion rates. Schedule follow-ups for pending quotations. Archive closed quotations. Generate pipeline reports.

### Process 3.3 – Track Customer Interactions
Log all customer communications (calls, emails, meetings). Maintain timeline view per customer. Use for relationship building and service improvement. Enable filtering by interaction type and date. Support analytics on customer engagement.

### Process 4.1 – Manage Payment Plans & Invoicing
Create structured payment plans for long-term agreements (6-24 months). Generate professional invoices with payment details. Link to customer accounts. Support multiple currencies. Track payment schedules and due dates.

### Process 4.2 – Process & Record Payments
Record customer payments across multiple channels (bank, check, GCash). Update outstanding balances. Generate receipts. Reconcile payments with invoices. Flag discrepancies for review.

### Process 4.3 – Monitor Due Dates & Exchange Rates
Automated scanning for payment due dates. Generate payment reminders. Fetch and update exchange rates for foreign transactions. Alert on significant rate changes. Support multi-currency calculations.

### Process 5.1 – Manage Quotation Templates
Create and maintain standardized quotation templates for different customer segments. Ensure templates include all required elements. Support customization with placeholders. Version control for template changes.

### Process 5.2 – Generate & Revise Quotations
Use templates and product data to generate professional quotations. Implement version control for revisions. Track all changes with timestamps. Maintain history of all versions. Support PDF export and email delivery.

### Process 5.3 – Track Quotation Status & Workflow
Manage quotation lifecycle status updates. Generate follow-up reminders for stale quotations. Provide visibility into pipeline stages. Support analytics on conversion rates. Enable status filtering and reporting.

### Process 5.4 – Manage Supporting Documents
Upload and store supporting documents (FDA certificates, supplier docs). Link documents to relevant products or quotations. Implement secure access controls. Support document search and retrieval. Maintain document metadata and versioning.

---

# MILESTONE 6

## DATA FLOW DIAGRAM

### Product Catalog Management Data Flow Diagram

The Product Catalog DFD illustrates how customers interact with the product catalog, submit inquiries, and how administrators manage product information.

**Level 0 Context Diagram:**
- External Entities: Customer, Administrator
- System: Product Catalog Management
- Data Flows: Product Queries, Inquiry Submissions, Catalog Updates

**Level 1 DFD:**
- Process 1.1: Browse and Search Products
- Process 1.2: Submit Product Inquiry
- Process 1.3: Manage Product Catalog
- Data Stores: Product Database, Inquiry Database

![Figure 8. Product Catalog Management Data Flow Diagram]

### Inventory Management Data Flow Diagram

The Inventory Management DFD shows stock movements, monitoring processes, and multi-location inventory management.

**Level 0 Context Diagram:**
- External Entities: Supplier, Receiving Department, Sales System, Administrator
- System: Inventory Management
- Data Flows: Stock Receipts, Sales Data, Transfer Requests, Inventory Reports

**Level 1 DFD:**
- Process 2.1: Record Stock Movement
- Process 2.2: Monitor Stock Levels & Aging
- Process 2.3: Manage Multi-Location Inventory
- Data Stores: Inventory Database, Movement Log, Location Database

![Figure 9. Inventory Management Data Flow Diagram]

### Customer Management Data Flow Diagram

The Customer Management DFD depicts customer information management, quotation handling, and interaction tracking.

**Level 0 Context Diagram:**
- External Entities: Customer, Sales Staff, System (Automated)
- System: Customer Management
- Data Flows: Customer Data, Quotation Requests, Interaction Logs, Reminders

**Level 1 DFD:**
- Process 3.1: Manage Customer Information
- Process 3.2: Handle Quotation Pipeline
- Process 3.3: Track Customer Interactions
- Data Stores: Customer Database, Quotation Pipeline, Interaction History

![Figure 10. Customer Management Data Flow Diagram]

### Financial Management Data Flow

The Financial Management DFD illustrates payment plan creation, invoice generation, payment processing, and financial monitoring.

**Level 0 Context Diagram:**
- External Entities: Customer, Finance Staff, Bank, System (Automated)
- System: Financial Management
- Data Flows: Payment Plans, Invoices, Payment Data, Due Date Alerts

**Level 1 DFD:**
- Process 4.1: Manage Payment Plans & Invoicing
- Process 4.2: Process & Record Payments
- Process 4.3: Monitor Due Dates & Exchange Rates
- Data Stores: Payment Database, Invoice Database, Exchange Rate Data

![Figure 11. Financial Management Data Flow]

### Document Management Data Flow Diagram

The Document Management DFD shows quotation generation, version control, status tracking, and supporting document management.

**Level 0 Context Diagram:**
- External Entities: Sales Staff, Administrator, Customer
- System: Document Management
- Data Flows: Template Data, Quotation Requests, Document Uploads, Generated Documents

**Level 1 DFD:**
- Process 5.1: Manage Quotation Templates
- Process 5.2: Generate & Revise Quotations
- Process 5.3: Track Quotation Status & Workflow
- Process 5.4: Manage Supporting Documents
- Data Stores: Template Library, Document Repository, Version History, Supporting Documents

![Figure 12. Document Management Data Flow Diagram]

---

# MILESTONE 7 - ENTITY RELATIONSHIP DIAGRAM

The Entity Relationship Diagram (ERD) provides a comprehensive view of the database structure for the RozMed Enterprises Inc. Management System, showing all entities, their attributes, and relationships.

**Key Entities:**
- **Customer** - Stores client information and institutional details
- **Product** - Medical equipment catalog with specifications
- **Inventory** - Stock levels and location tracking
- **Quotation** - Sales proposals and pricing
- **Invoice** - Billing and payment requests
- **Payment** - Transaction records and payment history
- **User** - System users and authentication
- **Document** - File repository for certificates and supporting materials
- **Interaction** - Customer communication logs
- **Location** - Storage facility and branch information

**Key Relationships:**
- Customer has many Quotations (1:N)
- Quotation has many Products (N:M via QuotationItem)
- Product has Inventory records (1:N)
- Customer has many Invoices (1:N)
- Invoice has many Payments (1:N)
- User logs many Interactions (1:N)
- Customer has many Interactions (1:N)
- Product has many Documents (1:N)

![Figure 13. Entity Relationship Diagram]

---

# MILESTONE 8 - LARAVEL SUBSYSTEM BUILD

## Inventory Management System

The Inventory Management System has been implemented using Laravel framework, providing a robust and scalable solution for tracking stock movements, monitoring inventory levels, and managing multi-location operations.

**Key Features Implemented:**
- Real-time inventory dashboard
- Stock in/out recording
- Inter-location transfers
- Aging inventory reports
- Daily scan logs
- Location-based inventory tracking

![Figure 14. Implementation of Inventory Management System in Laravel]

### Inventory Aging Report

The Aging Report feature identifies products that have been in stock beyond optimal durations, helping prevent obsolescence and optimize inventory turnover.

**Report Includes:**
- Product name and SKU
- Current location
- Days in stock
- Quantity on hand
- Recommended action
- Value at risk

![Figure 15. Inventory Aging Report]

### Inventory Daily Scan Log

The Daily Scan Log automatically records all inventory checks performed by the system, providing an audit trail and identifying patterns in stock movement.

**Log Details:**
- Scan timestamp
- Products scanned
- Quantities verified
- Discrepancies found
- User performing scan
- Location scanned

![Figure 16. Inventory Daily Scan Log]

### Inventory Stock In

The Stock In module handles receipt of new inventory from suppliers or transfers, updating stock levels in real-time.

**Features:**
- Supplier selection
- Product selection with autocomplete
- Quantity entry with validation
- Location assignment
- Batch/lot number tracking
- Receipt generation

![Figure 17. Inventory Stock In]

### Inventory Stock Out

The Stock Out module processes inventory dispatches for sales, transfers, or other removals from stock.

**Features:**
- Product selection
- Quantity validation against available stock
- Reason code selection
- Destination tracking
- Automatic stock level updates
- Dispatch documentation

![Figure 18. Inventory Stock Out]

### Inventory Update Location

The Update Location feature allows staff to move inventory within the same facility or reassign storage locations.

**Features:**
- Current location display
- New location selection
- Quantity specification
- Movement reason
- Audit trail creation
- Real-time location updates

![Figure 19. Inventory Update Location]

### Inventory New Transfer

The Transfer module manages inter-branch or inter-warehouse inventory movements, maintaining accurate stock levels across all locations.

**Features:**
- Source and destination location selection
- Product and quantity specification
- Transfer authorization
- In-transit tracking
- Receiving confirmation
- Dual-location stock updates

![Figure 20. Inventory New Transfer]

---

# MILESTONE 9 - FUNCTIONAL TEST CASE

## Inventory Management System

### Inventory Dashboard & Stock Monitoring

| Test Case ID | Test Case Name | Preconditions | Test Steps | Expected Results | Actual Results | Status |
|--------------|----------------|---------------|------------|------------------|----------------|--------|
| TC-INV-001 | View Inventory Dashboard with multiple items | Admin logged in, inventory data exists | 1. Navigate to Inventory Dashboard<br>2. Verify table loads with items<br>3. Check stock levels display | - Table loads with all items<br>- Stock quantities shown<br>- Low-stock items highlighted | Table loaded with 5 items, stock levels accurate, 2 items flagged low | Pass |
| TC-INV-010 | View Daily Scan Log for inventory audit | Scan data exists for today | 1. Click "Daily Scan Log" button<br>2. Verify modal opens<br>3. Check scan entries display | - Modal opens with animation<br>- All scans listed chronologically<br>- Scan details visible | Modal opened smoothly. 6 scan entries shown with timestamps | Pass |
| TC-INV-011 | Export Daily Scan Log to CSV | Scan log modal is open with data | 1. Click "Export CSV" button<br>2. Verify download initiates<br>3. Check file contents | - Export initiates<br>- Success toast shown<br>- CSV contains all scan data | Success toast: "CSV exported for 2025-02-15". File verified | Pass |

### Stock Movement & Transactions

| Test Case ID | Test Case Name | Preconditions | Test Steps | Expected Results | Actual Results | Status |
|--------------|----------------|---------------|------------|------------------|----------------|--------|
| TC-INV-003 | Record Stock In - Valid Input | Admin logged in, product exists | 1. Click "Record Stock In" button<br>2. Fill form with valid data<br>3. Submit form | - Form validates correctly<br>- Product added to inventory<br>- Success message displayed | Form validated all inputs. Product quantity increased from 10 to 25 | Pass |
| TC-INV-004 | Record Stock In - Invalid Input | Admin logged in | 1. Click "Record Stock In" button<br>2. Submit empty form<br>3. Verify validation | - Form shows validation errors<br>- No database changes<br>- Error messages clear | Validation errors: "Please select product", "Quantity required" | Pass |
| TC-INV-005 | Record Stock Out - Normal Removal | Admin logged in, Patient Monitor in stock (15 units) | 1. Click "Record Stock Out" button<br>2. Select product, enter quantity<br>3. Confirm removal | - Confirmation dialog appears<br>- Stock decrements correctly<br>- Transaction logged | Confirmation dialog showed correct details. Stock reduced to 8 units | Pass |

### Stock Transfers & Location Management

| Test Case ID | Test Case Name | Preconditions | Test Steps | Expected Results | Actual Results | Status |
|--------------|----------------|---------------|------------|------------------|----------------|--------|
| TC-INV-007 | Create Stock Transfer Workflow | Product exists in multiple locations | 1. Click "New Transfer" button<br>2. Select source/destination<br>3. Enter product and quantity<br>4. Initiate transfer | - Transfer path visualization shown<br>- Both locations updated<br>- Transfer record created | Path visualization: "Warehouse → Branch A". Stock updated correctly | Pass |
| TC-INV-008 | Stock Transfer - Invalid Location | Admin logged in | 1. Select same location for source/destination<br>2. Attempt transfer | - Validation error appears<br>- Transfer blocked<br>- Clear error message | Error: "Source and destination cannot be same" displayed | Pass |
| TC-INV-009 | Update Product Location | Item exists in inventory table | 1. Click "Update Location" button<br>2. Select new location<br>3. Confirm change | - Modal opens with current location<br>- Location updated in database<br>- Success confirmation | Modal opened with item name: "X-Ray Machine". Location updated | Pass |

### Aging & Reporting

| Test Case ID | Test Case Name | Preconditions | Test Steps | Expected Results | Actual Results | Status |
|--------------|----------------|---------------|------------|------------------|----------------|--------|
| TC-INV-002 | Open Aging Inventory Report | Inventory has items older than threshold | 1. Click "Aging Report" button<br>2. Verify modal opens<br>3. Review aging items | - Modal opens with animation<br>- Aging products listed with days<br>- Recommendations shown | Modal opened smoothly with animation. 3 items flagged: 180d, 210d, 95d | Pass |

### Integration & System Validation

| Test Case ID | Test Case Name | Preconditions | Test Steps | Expected Results | Actual Results | Status |
|--------------|----------------|---------------|------------|------------------|----------------|--------|
| TC-INT-001 | End-to-End: Inquiry to Payment | All systems integrated | 1. Customer submits inquiry<br>2. Create quotation<br>3. Convert to sale<br>4. Generate invoice<br>5. Record payment | - Data flows between all systems<br>- No data loss<br>- Complete audit trail | Inquiry appeared in CRM instantly. Full workflow completed successfully | Pass |
| TC-INT-002 | Real-time Stock Sync Between Systems | Multiple systems accessing inventory | 1. CRM creates sale<br>2. Check inventory levels<br>3. Verify real-time update | - Real-time synchronization<br>- Accurate stock levels<br>- No lag time | Sale reduced stock from 15 to 12 units within 1 second | Pass |

---

# MILESTONE 10 - FIGMA DESIGN

## Landing Page

The landing page serves as the primary entry point for customers, showcasing RozMed's product offerings and services.

**Key Features:**
- Hero section with company tagline
- Featured product categories
- Quick inquiry form
- Client testimonials
- Contact information

![Figure 21. RozMed Landing Page]

![Figure 22. RozMed Landing Page - Product Showcase]

![Figure 23. RozMed Landing Page - Footer Section]

This interface serves as a primary page of the website, it showcases the segments for feature medical equipment, laboratory supplies, and specialized diagnostic tools. The design emphasizes user-friendly navigation with clear categorization and high-quality product imagery.

## Admin's Dashboard

The Admin Dashboard provides a comprehensive overview of system performance, alerts, and key business metrics.

**Dashboard Widgets:**
- Revenue summary
- Pending quotations
- Low stock alerts
- Recent customer interactions
- Payment due dates
- System notifications

![Figure 24. Admin's Dashboard]

This interface highlights the overview of business activities, system alerts, and performance metrics. The dashboard is designed for quick decision-making with real-time data visualization and easy access to critical functions.

## Product Catalog Management System

### Product Catalog (Client's View)

The client-facing product catalog allows customers to browse, search, and inquire about medical equipment.

**Features:**
- Category-based navigation
- Advanced search filters
- Product detail pages
- Specification sheets
- Inquiry submission
- Comparison tool

![Figure 25. Product Catalog Dashboard]

![Figure 26. Product Selected on the Catalog]

This interface allows clients and guests to view, search, and ask for quotations of equipment and products. The design prioritizes product visibility with large images, clear specifications, and straightforward inquiry submission.

### Product Catalog Admin Portal

The administrative interface for managing the product catalog.

**Admin Features:**
- Add/edit/remove products
- Upload product images
- Manage specifications
- Set pricing
- View product analytics
- Aging product reports

![Figure 27. Product List on Admin's Dashboard]

![Figure 28. Aging Product Report]

This interface allows administrators to add and modify product names/titles, detailed descriptions, pricing information, and product images. The aging product report helps identify slow-moving inventory requiring attention.

## Inventory Management System

The inventory management interface provides tools for tracking stock across multiple locations.

**Features:**
- Stock in/out recording
- Location-based inventory view
- Transfer management
- Aging inventory alerts
- Daily scan logs
- Inventory reports

![Figure 29. Add New Product]

![Figure 30. New Products Arrived]

This interface allows administrators to manage all stock operations through intuitive forms and dashboards. Real-time updates ensure accurate inventory tracking across all locations.

## Customer Management System

The CRM interface centralizes customer information and interaction tracking.

**Features:**
- Customer profile management
- Communication history
- Quotation pipeline tracking
- Follow-up scheduling
- Email integration
- Analytics dashboard

![Figure 31. Customer Management System Dashboard]

![Figure 32. Email Drafts Created]

![Figure 33. Add Customer Details]

![Figure 34. Pending Customer Quotation]

![Figure 35. Quotation Sent to Customer]

![Figure 36. Follow-up Quotation Sent to Customer]

![Figure 37. Quotation that Customer Accepted and Agreed to Purchase]

The Customer Management System provides a complete view of each customer's journey, from initial inquiry through quotation, negotiation, and final sale. The interface supports efficient communication and relationship building.

## Finance Management System

The financial management interface handles payment plans, invoicing, and payment tracking.

**Features:**
- Payment plan creation
- Invoice generation
- Payment recording
- Due date monitoring
- Multi-currency support
- Financial reporting

![Figure 38. Finance Management System]

![Figure 39. List of Payment Plans]

![Figure 40. Payment Plan Creation]

![Figure 41. Invoice Generation]

The Finance Management System streamlines the creation of payment plans for extended-term agreements, generates professional invoices, and tracks all financial transactions with customers.

## Document Management System

The document management interface organizes quotations, templates, and supporting documents.

**Features:**
- Template library
- Quotation generation
- Version control
- Document repository
- Status tracking
- PDF export

![Figure 42. Document Management System]

![Figure 43. Create and/or Edit Quotation Template]

![Figure 44. Manage Supporting Documents]

The Document Management System ensures all quotations, certificates, and supporting materials are organized, version-controlled, and easily accessible to authorized personnel.

---

# MILESTONE 11 - NON-FUNCTIONAL TEST CASE / EVALUATION REPORT

The usability test evaluates the RozMed Enterprises Inc. Management System by surveying students enrolled in CS12L Software Engineering 1. The evaluation focuses on user interface design, ease of navigation, and overall user experience.

## Evidence of Testing

**Participant Demographics:**
- Total Participants: 4
- Background: CS12L Students
- Experience Level: Novice users with basic software experience
- Testing Duration: 30 minutes per participant
- Testing Environment: Controlled lab setting

**Testing Methodology:**
1. Introduction and consent
2. Task-based evaluation (guided scenarios)
3. Free exploration period
4. Feedback collection via questionnaire
5. Open-ended interview

**Evaluation Criteria:**
- Ease of navigation
- Interface clarity
- Feature discoverability
- Visual design
- System responsiveness
- Error handling

**Survey Results Summary:**

| Theme | Sample Responses | Frequency |
|-------|------------------|-----------|
| System is intuitive and easy to navigate | "Simple and easy to follow navigation" | 4 (100% of respondents) |
| Professional and aesthetically pleasing | "The design looks clean and simple" | 3 (75% of respondents) |
| Minor color/contrast improvements needed | "Some text is hard to read on certain backgrounds" | 2 (50% of respondents) |
| Positive overall experience | "I would use this system in a real work environment" | 4 (100% of respondents) |

## Analysis of Results with Recommendations for Improvements

**Strengths Identified:**
- High intuitiveness (100% agreement)
- Clear navigation structure
- Logical feature organization
- Responsive design
- Professional appearance

**Areas for Improvement:**
- Color contrast in some sections
- Button sizing on mobile devices
- Information density on certain pages
- Loading indicators for longer processes
- More prominent error messages

## Discussion

RozMed system received positive ratings, with all users finding the system easy to navigate and understand. The testing revealed that the interface successfully balances functionality with simplicity.

The users consistently mentioned that the interface felt intuitive and that they could explore the system without extensive training or documentation. This suggests the design achieves its goal of accessibility for users with varying technical backgrounds.

Despite these minor aesthetic concerns, novice users overall described the system as user-friendly and professional. The high rate of positive feedback indicates the design successfully meets the needs of its target users.

## Recommendations

Based on the feedback from participants, the RozMed Inventory Management System demonstrates strong usability fundamentals. However, targeted improvements can enhance the user experience further.

**First, visual design refinements (High Priority) must be addressed:** A consistent, accessible color palette should be implemented ensuring minimum 4.5:1 contrast ratio per WCAG guidelines. Typography should be standardized with clear hierarchy and readable font sizes (minimum 14px for body text). Button states (hover, active, disabled) need distinct visual feedback, and spacing should be optimized to reduce information density on complex pages.

**Following this, medium-priority enhancements should be pursued concurrently.** Information presentation should be improved through progressive disclosure patterns for complex forms and data tables. Loading states must be added for all asynchronous operations with appropriate skeleton screens or spinners. Error messaging should be enhanced with clear, actionable feedback and inline validation for form inputs.

**These visual and functional updates, conducting another round of usability testing with actual professionals from the medical equipment industry would provide valuable insights** into real-world usage patterns and requirements that may differ from student user testing.

## Ethical Considerations

Ethical considerations were carefully observed during the prototype evaluation. All participants were students from CS12L Software Engineering 1 course who volunteered for the testing session.

Participants were informed about the purpose of the evaluation—to improve system usability—and all feedback would be used solely for academic purposes and system improvement. Participation was entirely voluntary, and participants could withdraw at any time without penalty.

Transparency was maintained throughout the process, with participants understanding how their feedback would be used and that no personal identifying information would be published in the final report. All data collected was anonymized and stored securely.

---

# REFERENCES

[1] IEEE Standards Association: https://standards.ieee.org/ieee/14764/7701/#:~:text=Ideally%2C%20maintenance

[2] Web Content Accessibility Guidelines (WCAG) 2.1: 2025. https://www.w3.org/TR/WCAG21/.

[3] Conformance score: https://client.levelaccess.com/hc/en-us. Accessed: 2025-11-30.

[4] General Structured Data Guidelines | Google Search Central | Documentation | Google for Developers

[5] View of Design and implementation of a Pharmaceutical Inventory Database Management System: http://...

[6] Agboola, F.F. et al. 2022. Development Of A Web-Based Platform For Automating An Inventory Management System.

[7] Group, J.T.F.I.W. 2020. Security and privacy controls for information systems and organizations.

[8] ISO 25010: https://iso25000.com/en/iso-25000-standards/iso-25010.

[9] ISO/IEC 27001:2022: https://www.iso.org/standard/27001.

[10] S, S.S. et al. 2023. Hierarchical Document Approval System. International Journal for Research in Applied Science & Engineering Technology.

[11] Data encryption coverage: https://kpidepot.com/kpi/data-encryption-coverage.

[12] How to calculate CMMS ROI: Strategies for Maximum Savings: 2025. https://oxmaint.com/blog/post/cmms-roi

[13] VMS 101: How to achieve Contingent labor Cost Savings https://www.beeline.com/resources/vms-101

[14] Newsroom editorial office 2023. How companies can reduce printing paper copies using digital tools.

---

**END OF DOCUMENTATION**
