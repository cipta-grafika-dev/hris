<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- //error validation -->
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-6" role="alert">
            <h4>Form Validation</h4>
            </hr />
            <?php echo session()->getFlashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="content col-lg-6">
        <form action="<?= base_url('admin/edit_employee/' . $post['id']); ?>" method="post" id="edit_employeeform">
            <div class="body">
                <div class="form-group">
                    <input type="text" class="form-control" id="id_employee" name="id_employee" placeholder="Add id employee" value="<?= $post['id_employee'] ?>" autocomplite="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Add employee name" value="<?= $post['name'] ?>" autocomplite="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Add email" value="<?= $post['email'] ?>" autocomplite="off">
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Add birth place" value="<?= $post['birth_place'] ?>" autocomplite="off">
                    </div>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Add date of birth" value="<?= $post['birth_date'] ?>" autocomplite="off">
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="no_tlp" name="no_tlp" placeholder="Add phone number" value="<?= $post['no_tlp'] ?>" autocomplite="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Add address" value="<?= $post['address'] ?>" autocomplite="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="gender" name="gender" placeholder="Add gender" value="<?= $post['gender'] ?>" autocomplite="off">
                </div>
                <!-- <div class="form-group">
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Gender</option>
                        <option value="">Pria</option>
                        <option value="">Wanita</option>
                    </select>
                </div> -->
                <div class="form-group">
                    <input type="text" class="form-control" id="religion" name="religion" placeholder="Add employee religion" value="<?= $post['religion'] ?>" autocomplite="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="degree" name="degree" placeholder="Add last degree" value="<?= $post['degree'] ?>" autocomplite="off">
                </div>
                <!-- <div class="form-group">
                    <input type="text" class="form-control" id="divisi" name="divisi" placeholder="Add divisi" value="<?= $post['divisi'] ?>" autocomplite="off">
                </div> -->
                <div class="form-group">
                    <select name="divisi" id="divisi" class="form-control" value="<?= $post['divisi'] ?>">
                        <option value="">Divisi</option>
                        <?php foreach ($divisi as $div) : ?>
                            <option value=" <?= $div->id; ?>"><?= $div->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="position" name="position" placeholder="Add position" value="<?= $post['position'] ?>" autocomplite="off">
                </div>
            </div>
            <div class="footer">
                <a href="<?= base_url('admin/employee/'); ?>" type="button" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>