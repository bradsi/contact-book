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

<?php foreach($posts as $post) :?>
    <div class="card mb-5">
        <div class="card-body">
            <p class="card-text">
                <?= $this->e($post['first_name']) . ' ' . $this->e($post['last_name']) ?>
            </p>
        </div>

        <div class="card-footer" style="text-align: right;">
            <form class="d-inline" action="#" method="post">
                <!-- user could change value on frontend, need to validate on server -->
                <input type="number" name="id" hidden value="<?= $this->e($post['id']) ?>">
                <button type="submit" name="edit" class="btn btn-sm btn-outline-primary">Edit</button>
            </form>


            <form class="d-inline" action="/?action=deleteContact" method="post">
                <!-- user could change value on frontend, need to validate on server -->
                <input type="number" name="contactId" hidden value="<?= $this->e($post['id']) ?>">
                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>

        </div>
    </div>
<?php endforeach; ?>