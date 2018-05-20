<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-primary btn-sm" role="button" @click="createRow">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button class="btn btn-warning btn-sm" role="button" @click="editRow">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <button class="btn btn-danger btn-sm" role="button" @click="deleteRow">
          <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
        <button class="btn btn-default btn-sm" role="button" @click="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <div class="card-body">
      <dl class="row">
          <dt class="col-4">Label</dt>
          <dd class="col-8">{{ model.label }}</dd>

          <dt class="col-4">Keterangan</dt>
          <dd class="col-8">{{ model.keterangan }}</dd>
      </dl>
    </div>

    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md">
          <div class="col-md"><strong>ID</strong> : {{ model.user.id }}</div>
          <div class="col-md"><strong>Username</strong> : {{ model.user.name }}</div>
        </div>
        <div class="col-md">
          <div class="col-md text-right"><strong>Dibuat</strong> : {{ model.created_at }}</div>
          <div class="col-md text-right"><strong>Diperbarui</strong> : {{ model.updated_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {
        //
      },
      title: 'View Program Keahlian',
      model: {
        id          : '',
        label       : '',
        keterangan  : '',
        user_id     : '',
        created_at  : '',
        updated_at  : '',
        deleted_at  : '',

        user        : [],
      },
    }
  },
  mounted() {
    let app = this;

    axios.get('api/program-keahlian/'+this.$route.params.id)
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.id         = response.data.program_keahlian.id;
          this.model.label      = response.data.program_keahlian.label;
          this.model.keterangan = response.data.program_keahlian.keterangan;
          this.model.user_id    = response.data.program_keahlian.user_id;
          this.model.created_at = response.data.program_keahlian.created_at;
          this.model.updated_at = response.data.program_keahlian.updated_at;
          this.model.deleted_at = response.data.program_keahlian.deleted_at;

          this.model.user       = response.data.program_keahlian.user;

          if (this.model.user === null) {
            this.model.user = {
              'id'    : this.model.user_id,
              'name'  : '',
            };
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error',
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error',
        );

        app.back();
      });
  },
  methods: {
    createRow() {
      window.location = '#/admin/program-keahlian/create';
    },
    editRow() {
      window.location = '#/admin/program-keahlian/'+this.$route.params.id+'/edit';
    },
    deleteRow() {
      let app = this;

      swal({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          axios.delete('/api/program-keahlian/'+this.$route.params.id)
            .then(function(response) {
              if (response.data.status == true) {
                app.back();

                swal(
                  'Deleted',
                  'Yeah!!! Your data has been deleted.',
                  'success',
                );
              } else {
                swal(
                  'Failed',
                  'Oops... Failed to delete data.',
                  'error',
                );
              }
            })
            .catch(function(response) {
              swal(
                'Not Found',
                'Oops... Your page is not found.',
                'error',
              );
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal(
            'Cancelled',
            'Your data is safe.',
            'error',
          );
        }
      });
    },
    back() {
      window.location = '#/admin/program-keahlian';
    },
  },
}
</script>