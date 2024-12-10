<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">CRUD Application</h1>
    <ul class="nav nav-tabs" id="crudTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab" aria-controls="transactions" aria-selected="true">Transactions</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="currency-tab" data-bs-toggle="tab" data-bs-target="#currency" type="button" role="tab" aria-controls="currency" aria-selected="false">Currency</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="investors-tab" data-bs-toggle="tab" data-bs-target="#investors" type="button" role="tab" aria-controls="investors" aria-selected="false">Investors</button>
        </li>
    </ul>
    <div class="tab-content mt-4" id="crudTabsContent">
        <!-- Transactions Tab -->
        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal" data-type="transaction">Add New Transaction</button>
            <?php include 'transactions_form.php'; ?>
        </div>
        <!-- Currency Tab -->
        <div class="tab-pane fade" id="currency" role="tabpanel" aria-labelledby="currency-tab">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal" data-type="currency">Add New Currency</button>
            <?php include 'currency_form.php'; ?>
        </div>
        <!-- Investors Tab -->
        <div class="tab-pane fade" id="investors" role="tabpanel" aria-labelledby="investors-tab">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal" data-type="investor">Add New Investor</button>
            <?php include 'investors_form.php'; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRecordForm" method="POST" action="insert.php">
                <input type="hidden" name="type" id="form-type">
                <div class="modal-body">
                    <div id="dynamic-form-fields"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const formTypeField = document.getElementById('form-type');
    const dynamicFieldsContainer = document.getElementById('dynamic-form-fields');
    const modalTitle = document.getElementById('addRecordModalLabel');

    const fieldTemplates = {
        transaction: `
            <div class="mb-3">
                <label for="sender" class="form-label">Sender</label>
                <input type="text" class="form-control" id="sender" name="sender" required>
            </div>
            <div class="mb-3">
                <label for="receiver" class="form-label">Receiver</label>
                <input type="text" class="form-control" id="receiver" name="receiver" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.0000001" class="form-control" id="amount" name="amount" required>
            </div>
        `,
        currency: `
            <div class="mb-3">
                <label for="currencyname" class="form-label">Currency Name</label>
                <input type="text" class="form-control" id="currencyname" name="currencyname" required>
            </div>
            <div class="mb-3">
                <label for="currentvalue" class="form-label">Current Value</label>
                <input type="number" step="0.0000001" class="form-control" id="currentvalue" name="currentvalue" required>
            </div>
            <div class="mb-3">
                <label for="releasevalue" class="form-label">Release Value</label>
                <input type="number" step="0.0000001" class="form-control" id="releasevalue" name="releasevalue" required>
            </div>
        `,
        investor: `
            <div class="mb-3">
                <label for="investorsnumber" class="form-label">Investors Number</label>
                <input type="number" class="form-control" id="investorsnumber" name="investorsnumber" required>
            </div>
        `
    };

    document.querySelectorAll('[data-bs-target="#addRecordModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const type = button.getAttribute('data-type');
            formTypeField.value = type;
            modalTitle.textContent = `Add New ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            dynamicFieldsContainer.innerHTML = fieldTemplates[type];
        });
    });
</script>
</body>
</html>
