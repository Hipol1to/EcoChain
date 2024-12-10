<?php
// Fetch currency records
$currencies = $pdo->query("SELECT * FROM currency")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Currency Name</th>
            <th>Current Value</th>
            <th>Release Value</th>
            <th>Date Created</th>
            <th>Date Modified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($currencies as $currency): ?>
            <tr>
                <td><?= $currency['id'] ?></td>
                <td><?= htmlspecialchars($currency['currencyname']) ?></td>
                <td><?= $currency['currentvalue'] ?></td>
                <td><?= $currency['releasevalue'] ?></td>
                <td><?= $currency['datecreated'] ?></td>
                <td><?= $currency['datemodified'] ?></td>
                <td>
                    <button class="btn btn-warning btn-sm edit-currency" 
                            data-id="<?= $currency['id'] ?>" 
                            data-currencyname="<?= htmlspecialchars($currency['currencyname']) ?>"
                            data-currentvalue="<?= $currency['currentvalue'] ?>"
                            data-releasevalue="<?= $currency['releasevalue'] ?>">Edit</button>
                    <a href="delete.php?type=currency&id=<?= $currency['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Form -->
<div id="currency-edit-form" class="mt-3 d-none">
    <h5>Edit Currency</h5>
    <form method="POST" action="update.php?type=currency">
        <input type="hidden" name="id" id="currency-id">
        <div class="mb-3">
            <label for="currency-name" class="form-label">Currency Name</label>
            <input type="text" class="form-control" id="currency-name" name="currencyname">
        </div>
        <div class="mb-3">
            <label for="currency-current-value" class="form-label">Current Value</label>
            <input type="number" step="0.0000001" class="form-control" id="currency-current-value" name="currentvalue">
        </div>
        <div class="mb-3">
            <label for="currency-release-value" class="form-label">Release Value</label>
            <input type="number" step="0.0000001" class="form-control" id="currency-release-value" name="releasevalue">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
    document.querySelectorAll('.edit-currency').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('currency-id').value = btn.dataset.id;
            document.getElementById('currency-name').value = btn.dataset.currencyname;
            document.getElementById('currency-current-value').value = btn.dataset.currentvalue;
            document.getElementById('currency-release-value').value = btn.dataset.releasevalue;
            document.getElementById('currency-edit-form').classList.remove('d-none');
        });
    });
</script>
