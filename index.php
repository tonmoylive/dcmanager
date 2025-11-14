<?php include 'backend/check_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Customer Manager</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <style>
    body {
      background-color: #f8f9fa;
      padding-bottom: 60px; /* Footer height */
    }
    .card-header {
      background-color: #0d6efd;
      color: white;
    }
    #search::placeholder {
      font-size: 0.9rem;
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
    <!-- Header -->
    <div class="text-center mb-2 d-flex justify-content-between align-items-center">
      <h1 class="fw-bold text-primary" data-lang-key="title">Customer Manager</h1>
      <div>
        <button id="lang-switcher" class="btn btn-secondary btn-sm me-2">বাংলা</button>
        <a href="backend/logout.php" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i></a>
      </div>
    </div>
    <p class="text-muted text-left" data-lang-key="subtitle">Manage Debit/Credit Balances Quickly</p>

    <!-- Add Customer -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <h6 class="mb-0" data-lang-key="add_customer_title">Add New Customer</h6>
      </div>
      <div class="card-body">
        <form id="addCustomerForm" class="row g-3">
          <div class="col-md-6 col-12">
            <input
              type="text"
              name="name"
              class="form-control"
              placeholder="Customer Name"
              data-lang-key="customer_name_placeholder"
              required
            />
          </div>
          <div class="col-md-4 col-8">
            <input
              type="text"
              name="phone"
              class="form-control"
              placeholder="Phone (optional)"
              data-lang-key="phone_placeholder"
            />
          </div>
          <div class="col-md-2 col-4">
            <button type="submit" class="btn btn-success w-100" data-lang-key="add_button">Add</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Search -->
    <div class="mb-3">
      <input
        type="text"
        id="search"
        class="form-control form-control-lg"
        placeholder="🔍 Search customers by name"
        data-lang-key="search_placeholder"
      />
    </div>

    <!-- Customer List -->
    <div class="list-group shadow-sm" id="customerList"></div>
  </main>

  <!-- Sticky Footer -->
  <footer
    class="text-center py-3 border-top text-muted small fixed-bottom bg-light"
  >
    &copy; 2025
    <a href="https://mdanikbiswas.rf.gd/" class="text-decoration-none text-primary fw-semibold"
      >MD ANIK BISWAS</a
    >. All rights reserved.
  </footer>

  <script>
    const translations = {
        en: {
            title: "Customer Manager",
            subtitle: "Manage Debit/Credit Balances Quickly",
            add_customer_title: "Add New Customer",
            customer_name_placeholder: "Customer Name",
            phone_placeholder: "Phone (optional)",
            add_button: "Add",
            search_placeholder: "🔍 Search customers by name",
            lang_button: "বাংলা",
        },
        bn: {
            title: "কাস্টমার ম্যানেজার",
            subtitle: "ডেবিট/ক্রেডিট ব্যালেন্স দ্রুত পরিচালনা করুন",
            add_customer_title: "নতুন কাস্টমার যোগ করুন",
            customer_name_placeholder: "কাস্টমারের নাম",
            phone_placeholder: "ফোন (ঐচ্ছিক)",
            add_button: "যোগ করুন",
            search_placeholder: "🔍 নাম দিয়ে কাস্টমার খুঁজুন",
            lang_button: "ENG",
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
                } else {
                    elem.textContent = translations[lang][key];
                }
            }
        });
        document.getElementById('lang-switcher').textContent = translations[lang].lang_button;
    }

    document.getElementById('lang-switcher').addEventListener('click', () => {
        const newLang = currentLang === 'en' ? 'bn' : 'en';
        setLanguage(newLang);
    });

    const form = document.getElementById("addCustomerForm");

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(form);
      fetch("backend/add_customer.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((data) => {
          alert("Customer added!");
          form.reset();
          loadCustomers();
        });
    });

    document.getElementById("search").addEventListener("input", function () {
      loadCustomers(this.value);
    });

    function loadCustomers(query = "") {
      fetch("backend/search_customer.php?q=" + query)
        .then((res) => res.json())
        .then((data) => {
          const list = document.getElementById("customerList");
          list.innerHTML = "";
          if (data.length === 0) {
            list.innerHTML =
              '<div class="list-group-item text-center text-muted">No customers found.</div>';
            return;
          }
          data.forEach((c) => {
            const item = document.createElement("div");
            item.className =
              "list-group-item d-flex justify-content-between align-items-center flex-wrap";
            item.innerHTML = `
              <div>
                <div class="fw-bold">${c.name}</div>
                <small class="text-muted">${
                  c.phone ? `<a href="tel:${c.phone}" class="text-decoration-none text-muted">${c.phone}</a>` : "No phone provided"
                }</small>
              </div>
              <a href="balance.php?customer_id=${c.id}" class="btn btn-sm btn-outline-primary">Manage</a>
            `;
            list.appendChild(item);
          });
        });
    }

    window.onload = () => {
      loadCustomers();
      setLanguage(currentLang);
    };
  </script>
</body>
</html>