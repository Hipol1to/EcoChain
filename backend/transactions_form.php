<?php
// Fetch transactions
$transactions = $pdo->query("SELECT * FROM transactions")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Amount</th>
            <th>Date Created</th>
            <th>Date Modified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction['id'] ?></td>
                <td><?= htmlspecialchars($transaction['sender']) ?></td>
                <td><?= htmlspecialchars($transaction['receiver']) ?></td>
                <td><?= $transaction['amount'] ?></td>
                <td><?= $transaction['datecreated'] ?></td>
                <td><?= $transaction['datemodified'] ?></td>
                <td>
                    <button class="btn btn-warning btn-sm edit-transaction" 
                            data-id="<?= $transaction['id'] ?>" 
                            data-sender="<?= htmlspecialchars($transaction['sender']) ?>"
                            data-receiver="<?= htmlspecialchars($transaction['receiver']) ?>"
                            data-amount="<?= $transaction['amount'] ?>">Edit</button>
                    <a href="delete.php?type=transaction&id=<?= $transaction['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Form -->
<div id="transaction-edit-form" class="mt-3 d-none">
    <h5>Edit Transaction</h5>
    <form method="POST" action="update.php?type=transaction">
        <input type="hidden" name="id" id="transaction-id">
        <div class="mb-3">
            <label for="transaction-sender" class="form-label">Sender</label>
            <input type="text" class="form-control" id="transaction-sender" name="sender">
        </div>
        <div class="mb-3">
            <label for="transaction-receiver" class="form-label">Receiver</label>
            <input type="text" class="form-control" id="transaction-receiver" name="receiver">
        </div>
        <div class="mb-3">
            <label for="transaction-amount" class="form-label">Amount</label>
            <input type="number" step="0.0000001" class="form-control" id="transaction-amount" name="amount">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
    document.querySelectorAll('.edit-transaction').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('transaction-id').value = btn.dataset.id;
            document.getElementById('transaction-sender').value = btn.dataset.sender;
            document.getElementById('transaction-receiver').value = btn.dataset.receiver;
            document.getElementById('transaction-amount').value = btn.dataset.amount;
            document.getElementById('transaction-edit-form').classList.remove('d-none');
        });
    });
</script>
