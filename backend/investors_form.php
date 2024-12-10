<?php
// Fetch investors record (only one row is expected)
$investors = $pdo->query("SELECT * FROM investors")->fetch(PDO::FETCH_ASSOC);
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Investors Number</th>
            <th>Date Created</th>
            <th>Date Modified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $investors['id'] ?></td>
            <td><?= $investors['investorsnumber'] ?></td>
            <td><?= $investors['datecreated'] ?></td>
            <td><?= $investors['datemodified'] ?></td>
            <td>
                <button class="btn btn-warning btn-sm edit-investors" 
                        data-id="<?= $investors['id'] ?>" 
                        data-investorsnumber="<?= $investors['investorsnumber'] ?>">Edit</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<!-- Edit Form -->
<div id="investors-edit-form" class="mt-3 d-none">
    <h5>Edit Investors</h5>
    <form method="POST" action="update.php?type=investor">
        <input type="hidden" name="id" id="investors-id">
        <div class="mb-3">
            <label for="investors-number" class="form-label">Investors Number</label>
            <input type="number" class="form-control" id="investors-number" name="investorsnumber">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
    document.querySelector('.edit-investors').addEventListener('click', () => {
        document.getElementById('investors-id').value = <?= $investors['id'] ?>;
        document.getElementById('investors-number').value = <?= $investors['investorsnumber'] ?>;
        document.getElementById('investors-edit-form').classList.remove('d-none');
    });
</script>
      