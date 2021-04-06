<?php
$this->layout('layout', [
    'title' => 'Dashboard | Contact Book',
    'page' => 'dashboard'
]);
?>

<h1>Dashboard</h1>
<p>Welcome to your dashboard <?=$this->e($name)?></p>

<button type="button" class="btn btn-success mb-5">
    <a href="/new-contact" class="text-decoration-none text-white">Add Contact</a>
</button>

<?php foreach($contacts as $contact) :?>
    <div class="card mb-5">
        <div class="card-body">
            <p class="card-text">
                <?= $this->e($contact['first_name']) . ' ' . $this->e($contact['last_name']) ?>
            </p>
        </div>

        <div class="card-footer" style="text-align: right;">
            <form class="d-inline" action="/edit-contact" method="post">
                <!-- user could change value on frontend, need to validate on server -->
                <input type="number" name="contactId" hidden value="<?= $this->e($contact['id']) ?>">
                <input type="text" name="fName" hidden value="<?= $this->e($contact['first_name']) ?>">
                <input type="text" name="lName" hidden value="<?= $this->e($contact['last_name']) ?>">
                <button type="submit" name="edit" class="btn btn-sm btn-outline-primary">Edit</button>
            </form>


            <form class="d-inline" action="/?action=deleteContact" method="post">
                <!-- user could change value on frontend, need to validate on server -->
                <input type="number" name="contactId" hidden value="<?= $this->e($contact['id']) ?>">
                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>

        </div>
    </div>
<?php endforeach; ?>