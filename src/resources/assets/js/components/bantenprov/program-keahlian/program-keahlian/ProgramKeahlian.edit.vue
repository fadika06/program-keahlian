<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-primary btn-sm" role="button" @click="createRow">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button class="btn btn-info btn-sm" role="button" @click="viewRow">
          <i class="fa fa-eye" aria-hidden="true"></i>
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
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="label">Label</label>
              <input type="text" class="form-control" name="label" v-model="model.label" placeholder="Label" required autofocus>

              <field-messages name="label" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" name="keterangan" v-model="model.keterangan" placeholder="Keterangan" required>

              <field-messages name="keterangan" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Keterangan is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="user_id">Username</label>
              <v-select name="user_id" v-model="model.user" :options="user" placeholder="Username" required></v-select>

              <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">User is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>
      </vue-form>
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
      title: 'Add Program Keahlian',
      model: {
        id          : '',
        label       : '',
        keterangan  : '',
        nilai       : '',
        user_id     : '',
        created_at  : '',
        updated_at  : '',
        deleted_at  : '',

        user        : '',
      },
      user  : [],
    }
  },
  mounted(){
    this.reset();
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/program-keahlian/'+this.$route.params.id, {
            label       : this.model.label,
            keterangan  : this.model.keterangan,
            user_id     : this.model.user.id,
          })
          .then(response => {
            if (response.data.status == true) {
              if (response.data.error == false) {
                swal(
                  'Updated',
                  'Yeah!!! Your data has been updated.',
                  'success',
                );

                app.back();
              } else {
                swal(
                  'Failed',
                  'Oops... '+response.data.message,
                  'error',
                );
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
      }
    },
    reset() {
      let app = this;

      axios.get('api/program-keahlian/'+this.$route.params.id+'/edit')
        .then(response => {
          if (response.data.status == true && response.data.error == false) {
            this.model.id         = response.data.program_keahlian.id;
            this.model.label      = response.data.program_keahlian.label;
            this.model.keterangan = response.data.program_keahlian.keterangan;
            this.model.user_id    = response.data.program_keahlian.user_id;
            this.model.created_at = response.data.program_keahlian.created_at;
            this.model.updated_at = response.data.program_keahlian.updated_at;
            this.model.deleted_at = response.data.program_keahlian.deleted_at;

            if (response.data.program_keahlian.user === null) {
              this.model.user = response.data.current_user;
            } else {
              this.model.user = response.data.program_keahlian.user;
            }

            if (response.data.user_special == true) {
              this.user = response.data.users;
            } else {
              this.user.push(response.data.users);
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
    createRow() {
      window.location = '#/admin/program-keahlian/create';
    },
    viewRow() {
      window.location = '#/admin/program-keahlian/'+this.$route.params.id;
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
