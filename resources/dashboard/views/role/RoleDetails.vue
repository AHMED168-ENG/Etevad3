<template>
  <div class="role">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prroleDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الصلاحيه
                    </h4>

                    <div>
                      <div class="form-contole">
                        <label class="form-controle">اسم الصلاحيه</label>
                        <input
                          readonly
                          type="text"
                          v-model="role.data.name"
                          :class="[
                            'form-control',
                            role.errors.title ? 'is-invalid' : '',
                          ]"
                        />
                        <span v-if="role.errors.title" class="invalid-feedback">
                          {{ role.errors.title[0] }}
                        </span>
                      </div>
                      <hr />
                      <div class="form-contole">
                        <label class="form-controle">اذونات الصلاحيه</label>
                        <hr />

                        <div class="row">
                          <div
                            v-for="(permission, index) in allPermissions"
                            :key="index"
                            class="col-md-3"
                          >
                            <input
                              type="checkbox"
                              v-model="role.data.permissions"
                              :id="index"
                              :value="permission"
                              :checked="
                                role.data.permissions.includes(permission)
                                  ? 'checked'
                                  : 'checked'
                              "
                            />

                            <label :for="index"> {{ permission }} </label>
                          </div>
                        </div>
                        <span
                          v-if="role.errors.permissions"
                          class="invalid-feedback"
                        >
                          {{ role.errors.permissions[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateRole"
                    >
                      <i class="la la-check-square-o"></i>
                      حفظ
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "roleDetails",
  data: () => {
    return {
      allPermissions: [],
      role: {
        data: {
          id: "",
          name: "",
          permissions: [],
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update role =======================
    updateRole() {
      axios
        .put("/api/admin/role/update/" + this.role.data.id, this.role.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الصلاحيه بنجاح",
            });
            this.role.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.role.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update role =======================
    // ================= start part get role  =======================
    getRole() {
      axios
        .get("/api/admin/role/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.role.data = res.data.role;
            this.role.data.permissions = res.data.role.permissions.map(
              (ele) => ele.name
            );
          } else if (res.data.status == null) {
            Toast.fire({
              icon: "error",
              title: res.data.error,
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part get role  =======================
    // ================= start part get permisions with pagination =======================
    getPermissions() {
      axios
        .get("/api/admin/permission/all?")
        .then((res) => {
          if (res.data.status == true) {
            this.allPermissions = res.data.permissions.map((ele) => ele.name);
          } else if (res.data.status == null) {
            Toast.fire({
              icon: "error",
              title: res.data.error,
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part get permisions with pagination =======================
  },
  created() {
    this.getPermissions();
    this.getRole();
  },
};
</script>

<style lang="scss" scoped></style>
