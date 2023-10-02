<template>
  <div class="director">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prdirectorDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات المدير
                    </h4>
                    <section class="content contentOfImages d-flex">
                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق صوره المدير'
                          )
                        "
                        class="avatar-upload mx-1"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="iconUpload"
                              @change="setDirectorImage"
                            />
                            <label for="iconUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            title="director icon"
                            class="profile-director-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !director.data.image
                                ? '/images/test.png'
                                : !changeImage
                                ? `/images/directors/${director.data.image}`
                                : getImageFile()
                            "
                            alt="director profile picture"
                          />
                          <span
                            class="text-danger"
                            v-if="director.errors.image"
                          >
                            {{ director.errors.image[0] }}</span
                          >
                        </div>
                      </div>
                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle"> اسم المدير</label>
                        <input
                          :class="[
                            'form-control',
                            director.errors.name ? 'is-invalid' : '',
                          ]"
                          v-model="director.data.name"
                        />
                        <span
                          v-if="director.errors.name"
                          class="invalid-feedback"
                        >
                          {{ director.errors.name[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle"> لقب المدير</label>
                        <input
                          :class="[
                            'form-control',
                            director.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="director.data.title"
                        />
                        <span
                          v-if="director.errors.title"
                          class="invalid-feedback"
                        >
                          {{ director.errors.title[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle"> وظيفه المدير</label>
                        <input
                          :class="[
                            'form-control',
                            director.errors.jop ? 'is-invalid' : '',
                          ]"
                          v-model="director.data.jop"
                        />
                        <span
                          v-if="director.errors.jop"
                          class="invalid-feedback"
                        >
                          {{ director.errors.jop[0] }}
                        </span>
                      </div>

                      <div v-show="director.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="director.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="director.errors.active"
                          class="invalid-feedback"
                        >
                          {{ director.errors.active[0] }}
                        </span>
                      </div>

                      <div v-if="!director.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="director.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1" selected>مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="director.errors.active"
                          class="invalid-feedback"
                        >
                          {{ director.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateDirector"
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
  name: "directorDetails",
  data: () => {
    return {
      changeImage: false,
      director: {
        data: {
          id: "",
          title: "",
          name: "",
          jop: "",
          image: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update director =======================
    updateDirector() {
      axios
        .put(
          "/api/admin/director/update/" + this.director.data.id,
          this.director.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات المدير بنجاح",
            });
            this.director.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.director.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update director =======================
    // ================= start part get director  =======================
    getDirector() {
      axios
        .get("/api/admin/director/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.director.data = res.data.director;
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
    // ================= end part get director  =======================
    // ================= start part set director icon  =======================
    setDirectorImage(e) {
      this.director.errors = {};
      this.changeImage = true;
      this.director.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/director/upload/file/" + this.$route.params.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل صوره المدير بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.director.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set director icon  =======================

    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.director.data.image);
    },

    // ================= end part set image  =======================
  },
  created() {
    this.getDirector();
  },
};
</script>

<style lang="scss" scoped></style>
