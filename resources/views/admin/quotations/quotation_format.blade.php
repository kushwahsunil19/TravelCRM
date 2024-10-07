<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Static Estimate</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <style>
      /* General Layout */
 
      body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            width: 700px;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ddd;
        }
      /* Fixed Footer Styling */
      .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        text-align: center;
        line-height: 40px;
        background-color: #f8f9fa;
      }

      /* Table Styling */
      .table {
        border-collapse: collapse;
        width: 100%;
      }

      .table th,
      .table td {
        border: none;
        padding: 4px;
      }

      .table th {
        background-color: #84dfd0;
      }

      h3,
      h1,
      p {
        margin: 0;
      }

      .row {
        margin-bottom: 10px;
      }

      .navbar-brand img {
        height: 90px;
      }

      .total-section {
        display: flex;
        justify-content: left;
        align-items: flex-start;
        margin-top: 20px;
      }

      .total {
        text-align: right;
        margin-top: 2px;
      }

      /* Print Styles */
      .header {
        width: 100%;
        margin-bottom: 20px;
      }

      @media print {
        .header {
    position: static; /* Make the header static during print */
    top: 0;
    z-index: 1; /* Ensure the header is on top of content */
    page-break-after: avoid; /* Avoid the header repeating after a page break */
  }
  
  body {
    margin-top: 50px; /* Add margin to ensure content doesn't get hidden under the header */
  }

  /* Optionally, hide unnecessary elements during printing */
  .no-print {
    display: none;
  }

        .footer {
          position: fixed;
          bottom: 0;
          left: 0;
          right: 0;
          background-color: #f8f9fa;
        }

        .content-wrapper {
          page-break-inside: avoid; /* Avoid breaking inside content blocks */
        }

        /* Handle page breaks for long tables or sections */
        .table tbody tr {
          page-break-inside: avoid; /* Avoid breaking inside table rows */
        }

        .table thead {
          display: table-header-group; /* Ensure table headers are repeated on each page */
        }

        .footer {
          page-break-before: always;
        }

        .notes {
          page-break-inside: avoid; /* Prevent breaking inside notes */
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
    <div class="header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid" style="padding: 0px">
          <a class="navbar-brand" href="#"><img src="https://centurionluxurytravels.in/CRM/public/assets/img/logo2.png" alt="" /></a>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item text-end">
              <h1>ESTIMATE</h1>
              <b>INDIA WEBSOFT</b><br />
              106, NRK BIZPARK, Behind C21 Mall, Scheme 54 PU4 <br />
              Vijay Nagar <br />
              Indore, Madhya Pradesh 452001,<br />
              India <br />
              Phone: 7314009744 <br />
              Mobile: +91-9755907700, +91-9755900560 <br />
              <a
                href="http://www.indiawebsoft.com"
                target="_blank"
                style="text-decoration: none; color: black"
                >www.indiawebsoft.com</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <hr />

    <div class="content-wrapper" style="padding: 0px">
      <div class="row">
        <div class="col-6">
          <h7 style="color: #cbc5c5">BILL TO</h7>
          <p>
            <b>Shramik Nagrik Sahkaari Bank Ltd.</b><br />
            Mr. Deepak Choukse<br />
            123, Devi Ahily Marg Sharam Shivir<br />
            Jail Road, Indore, Madhya Pradesh 452001<br />
            India<br />
            <br />
            <a
              href="mailto:snk.indore@gmail.com"
              style="text-decoration: none; color: black"
              >snk.indore@gmail.com</a
            >
          </p>
        </div>
        <div class="col-6 text-end">
          <p>
            <b>Estimate Number:</b> 1197<br />
            <b>Estimate Date:</b> September 25, 2024<br />
            <b>Valid Until:</b> October 25, 2024<br />
            <b>Estimate Total (INR):</b> ₹26,223.00
          </p>
        </div>
      </div>
    </div>

    <!-- Services Table -->
    <div class="content-wrapper" style="padding: 0px">
      <table class="table">
        <thead>
          <tr>
            <th>Service</th>
            <th>Price (INR)</th>
            <th>Amount (INR)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <b>WEBSITE SECURITY AUDIT</b><br />
              WEBSITE VAPT AUDIT REPORT YEAR 2024-25 – Round 1<br />
              <a
                href="https://www.shramiknagrikbank.com"
                target="_blank"
                style="text-decoration: none; color: black"
                >https://www.shramiknagrikbank.com</a
              ><br /><br />
              I. Network Security<br />
              II. Web Application Security<br />
              III. Content Security<br />
              IV. Password and Authentication<br />
              V. Database Security<br />
              VI. Server and Hosting<br />
              VII. Compliance and Regulations<br />
              VIII. Vulnerability Scanning and Penetration Testing<br />
              IX. Maintenance and Monitoring
            </td>
            <td>₹18,000.00</td>
            <td>₹18,000.00</td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr />

    <!-- Total and Notes Section -->
    <div class="total" style="padding: 0px">
      <p>
        <strong>Total:</strong> $26,223.00<br />
        <br /><strong>Estimate Total (INR):</strong> $26,223.00
      </p>
    </div>

    <!-- Notes / Terms Section -->
    <div class="note1">
      <div class="content-wrapper total-section">
        <div class="notes">
          <h6>Notes / Terms</h6>
          <p>
            Timeline: 10 working days<br />
            Advance: 100%<br />
            • Payments should be made in favor of “India Websoft”<br /><br />
            <strong>ACCOUNT DETAIL</strong><br />
            Account Name: India Websoft<br />
            Bank: Punjab National Bank<br />
            Branch: Indore<br />
            Acc. Type: Current<br />
            Acc. Number: 2157002100013956<br />
            IFSC Code: PUNB0215700
          </p>
        </div>
      </div>
    </div>
    <div class="note1">
      <div class="content-wrapper total-section">
        <div class="notes">
          <h6>Notes / Terms</h6>
          <p>
            Timeline: 10 working days<br />
            Advance: 100%<br />
            • Payments should be made in favor of “India Websoft”<br /><br />
            <strong>ACCOUNT DETAIL</strong><br />
            Account Name: India Websoft<br />
            Bank: Punjab National Bank<br />
            Branch: Indore<br />
            Acc. Type: Current<br />
            Acc. Number: 2157002100013956<br />
            IFSC Code: PUNB0215700
          </p>
        </div>
      </div>
    </div>
   

    <div class="footer">
      <p>Page 1 of 3 for Estimate #1197</p>
    </div>
    </div>
  </body>
</html>