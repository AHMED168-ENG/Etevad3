<template>
  <div class="users">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.preventDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بياناتي الشخصيه
                    </h4>
                    <section class="content">
                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق صوره المستخدم'
                          )
                        "
                        class="avatar-upload"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              accept=".png, .jpg, .jpeg"
                              @change="setImage"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            class="profile-user-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !user.data.image
                                ? '/images/avatar.jpg'
                                : !changeImage
                                ? `/images/user/${user.data.image}`
                                : getImageFile()
                            "
                            alt="User profile picture"
                          />
                          <span class="text-danger" v-if="user.errors.image">
                            {{ user.errors.image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="name"> الاسم </label>
                          <input
                            type="text"
                            id="name"
                            class="form-control"
                            placeholder="ادخل الاسم "
                            v-model="user.data.name"
                          />
                          <span class="text-danger" v-if="user.errors.name">
                            {{ user.errors.name[0] }}</span
                          >
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="email"> الايميل </label>
                          <input
                            type="email"
                            id="email"
                            class="form-control"
                            placeholder="ادخل الايميل "
                            v-model="user.data.email"
                          />
                          <span class="text-danger" v-if="user.errors.email">
                            {{ user.errors.email[0] }}</span
                          >
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="password"> الرقم السري </label>
                          <input
                            autocomplete="new-password"
                            type="password"
                            id="password"
                            class="form-control"
                            placeholder="ادخل الرقم السري "
                            v-model="user.data.password"
                          />
                          <span class="text-danger" v-if="user.errors.password">
                            {{ user.errors.password[0] }}</span
                          >
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="addres"> العنوان </label>
                          <input
                            type="text"
                            id="addres"
                            class="form-control"
                            placeholder="ادخل العنوان "
                            v-model="user.data.addres"
                          />
                          <span class="text-danger" v-if="user.errors.addres">
                            {{ user.errors.addres[0] }}</span
                          >
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="age"> العمر </label>
                          <input
                            type="number"
                            id="age"
                            class="form-control"
                            placeholder="ادخل العمر "
                            v-model="user.data.age"
                          />
                          <span class="text-danger" v-if="user.errors.age">
                            {{ user.errors.age[0] }}</span
                          >
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="mobile"> الموبيل </label>
                          <input
                            type="number"
                            id="mobile"
                            class="form-control"
                            placeholder="ادخل الموبيل "
                            v-model="user.data.mobile"
                          />
                          <span class="text-danger" v-if="user.errors.mobile">
                            {{ user.errors.mobile[0] }}</span
                          >
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="mobile"> الصلاحيات </label>

                          <input
                            type="text"
                            class="form-control"
                            :value="user.data.role"
                            readonly
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateUser"
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
  name: "UserDetails",
  data: () => {
    return {
      changeImage: false,
      user: {
        data: {
          name: "",
          email: "",
          password: "",
          addres: "",
          mobile: "",
          age: "",
          role: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update user =======================
    updateUser() {
      axios
        .put("/api/admin/user/updatePersonalData", this.user.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بياناتك بنجاح يجب عليك التسجيل من جديد",
            });
            this.user.errors = {};
            this.logout();
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.user.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update user =======================
    logout() {
      axios
        .post("/api/admin/auth/logout")
        .then((result) => {
          if (result.data.status == true) {
            this.$router.push({ name: "تسجيل الدخول" });
            this.$store.commit("logout");
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
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
    // ================= start part get user  =======================
    getUser() {
      let AdminToken = window.localStorage.getItem("AdminToken");
      axios
        .get("/api/admin/auth/me", {
          headers: {
            Authorization: "Bearer " + AdminToken,
          },
        })
        .then((res) => {
          if (res.data.status == true) {
            this.user.data = res.data.user;
            this.user.data.password = "";
            this.user.data.role = res.data.user.roles[0].name;
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
    // ================= end part get user  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.user.errors = {};
      this.changeImage = true;
      this.user.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/user/upload/file/" + this.$store.getters.getAdminData.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل الصوره بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.user.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.user.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getUser();
  },
};
</script>

<style lang="scss" scoped>
.profile-user-img {
  border-radius: 50%;
  width: 100%;
  height: 100%;
}

.avatar-upload {
  position: relative;
  width: 8.5%;
  aspect-ratio: 1/1;
  margin: auto;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 50%;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  padding: 2px;
  .avatar-preview {
    width: 100%;
    height: 100%;
  }
  .avatar-edit {
    position: absolute;
    right: 1px;
    z-index: 1;
    top: 90px;
    input {
      display: none;
      + label {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #ffffff;
        border: 1px solid #d2d6de;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        &:hover {
          background: #f1f1f1;
          border-color: #d6d6d6;
        }
      }
    }
  }
}
</style>
