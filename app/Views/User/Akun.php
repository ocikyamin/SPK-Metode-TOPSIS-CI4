<?= $this->extend('User/Template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Users</h5>
        <p class="mb-0">
            <button id="add" class="btn btn-primary">Tambah</button>
        </p>
        <div class="table-responsive mt-4">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama User</th>
                        <th>Status</th>
                        <th><i class="ti ti-settings"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no =1;
                    foreach ($list_user as $k) {?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$k['email']?></td>
                        <td><?=$k['nama_user']?></td>
                        <td><?=$k['status']==1 ? 'Aktif' : 'Non Aktif' ?></td>
                        <td>
                            <button onclick="Edit(<?=$k['id']?>)" class="btn btn-info btn-sm">Edit</button>
                            <?php
                            if (UserLogin()->id !== $k['id']) {
                               ?>
                            <button onclick="Hapus(<?=$k['id']?>)" class="btn btn-danger btn-sm">Hapus</button>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
</div>

<div class="modalview"></div>
<script>
$('#add').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?=base_url('user/add')?>",
        data: 'data',
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-user').modal('show')
        }
    });
});

function Edit(id) {
    $.ajax({
        url: "<?=base_url('user/edit')?>",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-user').modal('show')
        }
    });

}

function Hapus(id) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Apakah Anda Yakin ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?=base_url('user/delete')?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Sukses',
                            text: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location = response.url
                        })
                    }
                }
            });

        }
    })

}
</script>

<?= $this->endSection() ?>