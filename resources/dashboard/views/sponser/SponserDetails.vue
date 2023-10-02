<template>
  <div class="sponser">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prsponserDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات البطل
                    </h4>
                    <section class="content">
                      <div class="avatar-upload">
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              @change="setImage"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            class="profile-sponser-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !sponser.data.logo
                                ? '/images/test.png'
                                : !changeImage
                                ? `/images/sponsers/${sponser.data.logo}`
                                : getImageFile()
                            "
                            alt="sponser profile picture"
                          />
                          <span class="text-danger" v-if="sponser.errors.logo">
                            {{ sponser.errors.logo[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">مسمي الداعم</label>
                        <input
                          type="text"
                          :class="[
                            'form-control',
                            sponser.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="sponser.data.title"
                        />

                        <span
                          v-if="sponser.errors.title"
                          class="invalid-feedback"
                        >
                          {{ sponser.errors.title[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">لينك الداعم</label>
                        <input
                          :class="[
                            'form-control',
                            sponser.errors.company_url ? 'is-invalid' : '',
                          ]"
                          v-model="sponser.data.company_url"
                        />
                        <span
                          v-if="sponser.errors.company_url"
                          class="invalid-feedback"
                        >
                          {{ sponser.errors.company_url[0] }}
                        </span>
                      </div>

                      <div v-show="sponser.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="sponser.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="sponser.errors.active"
                          class="invalid-feedback"
                        >
                          {{ sponser.errors.active[0] }}
                        </span>
                      </div>

                      <div v-if="!sponser.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="sponser.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1" selected>مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="sponser.errors.active"
                          class="invalid-feedback"
                        >
                          {{ sponser.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updatesponser"
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
  name: "sponserDetails",
  data: () => {
    return {
      changeImage: false,
      sponser: {
        data: {
          id: "",
          title: "",
          company_url: "",
          active: 1,
          logo: "",
        },
        errors: {},
      },
    };
  },
  methods: {
    // ================= start part update sponser =======================
    updatesponser() {
      axios
        .put(
          "/api/admin/sponser/update/" + this.sponser.data.id,
          this.sponser.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات البطل بنجاح",
            });
            this.sponser.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.sponser.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update sponser =======================
    // ================= start part get sponser  =======================
    getSponser() {
      axios
        .get("/api/admin/sponser/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.sponser.data = res.data.sponser;
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
    // ================= end part get sponser  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.sponser.errors = {};
      this.changeImage = true;
      this.sponser.data.logo = e.target.files[0];
      let formData = new FormData();
      formData.append("logo", e.target.files[0]);
      axios
        .post(
          "/api/admin/sponser/upload/file/" + this.$route.params.id,
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
            this.sponser.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.sponser.data.logo);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getSponser();
  },
};
</script>

<style lang="scss" scoped>
.profile-sponser-img {
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
