<?php include 'backend/check_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Customer Balance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      background-color: #f8f9fa;
      padding-bottom: 60px; /* Footer height */
    }
    .card-header {
      background-color: #0d6efd;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .card {
      border-radius: 10px;
    }
    .summary-box span {
      font-weight: 600;
    }
    body {
      user-select: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <?php include 'backend/check_auth.php'; ?>
  <main class="container py-4 flex-grow-1">
    <!-- Customer Name -->
    <div class="card mb-4">
      <div class="card-header">
          <h4 id="customerName" class="mb-0">Loading customer...</h4>
          <div class="dropdown">
            <button class="btn btn-link" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" id="editCustomer">Edit Profile</a></li>
                <li><a class="dropdown-item" href="#" id="deleteCustomer">Delete</a></li>
            </ul>
          </div>
        </div>
      <div class="card-body">
        <form id="balanceForm" class="row gy-3">
          <input type="hidden" id="customer_id" />
          <input type="hidden" id="balance_id" />
          <div class="col-md-4 col-sm-6">
            <select class="form-select" id="balance_type">
              <option value="debit" data-lang-key="debit_option">Debit</option>
              <option value="credit" data-lang-key="credit_option">Credit</option>
            </select>
          </div>
          <div class="col-md-4 col-sm-6">
            <input
              type="number"
              step="0.01"
              class="form-control"
              id="amount"
              placeholder="Amount (BDT)"
              data-lang-key="amount_placeholder"
              required
            />
          </div>
          <div class="col-md-4 col-12">
            <button type="submit" class="btn btn-success w-100" data-lang-key="save_button">
              Save Balance
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Summary -->
    <div class="card mb-4">
      <div class="card-header bg-dark text-white">
        <h5 class="mb-0" data-lang-key="summary_title">Balance Summary</h5>
      </div>
      <div class="card-body row text-center summary-box">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
          <span class="text-primary" data-lang-key="debit_label">Debit:</span><br />
          <span id="debit">BDT 0.00</span>
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
          <span class="text-success" data-lang-key="credit_label">Credit:</span><br />
          <span id="credit">BDT 0.00</span>
        </div>
        <div class="col-12 col-md-4">
          <span class="text-danger" data-lang-key="due_balance_label">Due Balance:</span><br />
          <strong id="due_balance" class="text-danger">BDT 0.00</strong>
        </div>
      </div>
    </div>

    <!-- History -->
    <div class="card">
      <div class="card-header bg-secondary text-white">
        <h5 class="mb-0" data-lang-key="history_title">Balance History</h5>
      </div>
      <ul class="list-group list-group-flush" id="historyList"></ul>
    </div>
  </main>

  <!-- Edit Customer Modal -->
  <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="editCustomerForm">
                      <div class="mb-3">
                          <label for="editCustomerName" class="form-label">Customer Name <span style="color: red;">*</span></label>
                          <input type="text" class="form-control" id="editCustomerName" required>
                      </div>
                      <div class="mb-3">
                          <label for="editCustomerPhone" class="form-label">Phone Number</label>
                          <input type="text" class="form-control" id="editCustomerPhone">
                      </div>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Sticky Footer -->
  <footer
    class="text-center py-3 border-top text-muted small fixed-bottom bg-light"
  >
    &copy; 2025
    <a href="https://mdanikbiswas.rf.gd/" class="text-decoration-none text-primary fw-semibold"
      >MD ANIK BISWAS</a
    >. All rights reserved.
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const translations = {
        en: {
            delete_button: "Delete",
            debit_option: "Debit",
            credit_option: "Credit",
            amount_placeholder: "Amount (BDT)",
            save_button: "Save Balance",
            summary_title: "Balance Summary",
            debit_label: "Debit:",
            credit_label: "Credit:",
            due_balance_label: "Due Balance:",
            history_title: "Balance History",
        },
        bn: {
            delete_button: "মুছে ফেলুন",
            debit_option: "বাকি",
            credit_option: "জমা",
            amount_placeholder: "টাকার পরিমাণ ( ইংরেজিতে )",
            save_button: "ব্যালেন্স সংরক্ষণ করুন",
            summary_title: "ব্যালেন্সের সারসংক্ষেপ",
            debit_label: "বাকি:",
            credit_label: "জমা:",
            due_balance_label: "পাওনা:",
            history_title: "ব্যালেন্সের ইতিহাস",
        }
    };

    let currentLang = localStorage.getItem('language') || 'en';

    function setLanguage(lang) {
        currentLang = lang;
        localStorage.setItem('language', lang);
        document.querySelectorAll('[data-lang-key]').forEach(elem => {
            const key = elem.getAttribute('data-lang-key');
            if (translations[lang][key]) {
                if (elem.tagName === 'INPUT' || elem.tagName === 'TEXTAREA') {
                     if(elem.type === 'submit' || elem.type === 'button'){
                         elem.value = translations[lang][key];
                    } else {
                         elem.placeholder = translations[lang][key];
                    }
                } else if (elem.tagName === 'OPTION') {
                    elem.textContent = translations[lang][key];
                } else {
                    elem.textContent = translations[lang][key];
                }
            }
        });
    }

    const customer_id = new URLSearchParams(window.location.search).get(
      "customer_id"
    );
    document.getElementById("customer_id").value = customer_id;

    function loadCustomerName() {
      fetch(`backend/get_customer_info.php?customer_id=${customer_id}`)
        .then((res) => res.json())
        .then((data) => {
          const customerNameEl = document.getElementById("customerName");
          if (data.name) {
            let html = `${data.name}`;
            if (data.phone) {
              html += ` <small><a href="tel:${data.phone}" class="text-white text-decoration-none">${data.phone}</a></small>`;
            }
            customerNameEl.innerHTML = html;
          } else {
            customerNameEl.textContent = "Customer not found";
          }
        });
    }

    function loadSummary() {
      fetch(`backend/get_customer_balance.php?customer_id=${customer_id}`)
        .then((res) => res.json())
        .then((data) => {
          document.getElementById("debit").textContent =
            "BDT " + data.debit.toFixed(2);
          document.getElementById("credit").textContent =
            "BDT " + data.credit.toFixed(2);
          document.getElementById("due_balance").textContent =
            "BDT " + data.due_balance.toFixed(2);
        });
    }

    function loadHistory() {
      fetch(`backend/get_balance_history.php?customer_id=${customer_id}`)
        .then((res) => res.json())
        .then((data) => {
          const list = document.getElementById("historyList");
          list.innerHTML = "";
          data.forEach((h) => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            if (h.balance_type.toLowerCase() === "credit") {
              li.classList.add("bg-success", "bg-opacity-10");
            }
            li.textContent = `${h.timestamp} — ${h.balance_type.toUpperCase()}: ${h.amount}`;
            const editButton = document.createElement("button");
            editButton.textContent = "📝";
            editButton.className = "btn btn-sm float-end edit-balance-btn";
            editButton.setAttribute("data-id", h.id);
            editButton.setAttribute("data-type", h.balance_type);
            editButton.setAttribute("data-amount", h.amount);
            li.appendChild(editButton);
            list.appendChild(li);
          });

          document.querySelectorAll(".edit-balance-btn").forEach(button => {
            button.addEventListener("click", function() {
              document.getElementById("balance_id").value = this.dataset.id;
              document.getElementById("balance_type").value = this.dataset.type.toLowerCase();
              document.getElementById("amount").value = parseFloat(this.dataset.amount);
              document.getElementById("save_button").textContent = "Update Balance";
            });
          });
        });
    }

    document
      .getElementById("balanceForm")
      .addEventListener("submit", function (e) {
        e.preventDefault();
        const data = new FormData();
        const balanceId = document.getElementById("balance_id").value;
        const actionType = balanceId ? "edit" : "add";

        data.append("customer_id", customer_id);
        data.append("balance_type", document.getElementById("balance_type").value);
        data.append("amount", document.getElementById("amount").value);
        if (balanceId) {
          data.append("balance_id", balanceId);
        }
        data.append("action_type", actionType);

        fetch("backend/add_edit_balance.php", {
          method: "POST",
          body: data,
        }).then((res) => res.json()).then(() => {
          alert("Balance updated!");
          loadSummary();
          loadHistory();
        });
      });

    document.getElementById("deleteCustomer").addEventListener("click", function () {
      if (confirm("Are you sure you want to delete this customer? This action cannot be undone.")) {
        const data = new FormData();
        data.append("customer_id", customer_id);

        fetch("backend/delete_customer.php", {
          method: "POST",
          body: data,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              alert("Customer deleted successfully.");
              window.location.href = "index.php";
            } else {
              alert("Error deleting customer: " + data.error);
            }
          });
      }
    });

    document.getElementById("editCustomer").addEventListener("click", function() {
        fetch(`backend/get_customer_info.php?customer_id=${customer_id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("editCustomerName").value = data.name;
                document.getElementById("editCustomerPhone").value = data.phone;
                var myModal = new bootstrap.Modal(document.getElementById('editCustomerModal'), {
                    keyboard: false
                });
                myModal.show();
            });
    });

    document.getElementById("editCustomerForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const data = new FormData();
        data.append("customer_id", customer_id);
        data.append("name", document.getElementById("editCustomerName").value);
        data.append("phone", document.getElementById("editCustomerPhone").value);

        fetch("backend/edit_customer.php", {
            method: "POST",
            body: data,
        }).then(res => res.json()).then(data => {
            if (data.status === "success") {
                alert("Customer updated successfully.");
                loadCustomerName();
                var myModalEl = document.getElementById('editCustomerModal');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
            } else {
                alert("Error updating customer: " + data.error);
            }
        });
    });

    window.onload = () => {
      loadCustomerName();
      loadSummary();
      loadHistory();
      setLanguage(currentLang);
    };
  </script>
</body>
</html>