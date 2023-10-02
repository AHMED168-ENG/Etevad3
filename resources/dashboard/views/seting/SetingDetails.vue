<template>
  <div class="seting">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prsetingDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الاعدادات
                    </h4>
                    <section class="content contentOfImages d-flex">
                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق اللوجو العلوي للاعدادات'
                          )
                        "
                        class="avatar-upload mx-1"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="iconUpload"
                              accept=".png, .jpg, .jpeg"
                              @change="setSiteUpperLogo"
                            />
                            <label for="iconUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            title="site upper logo"
                            class="profile-seting-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !seting.data.site_upper_logo
                                ? '/images/test.png'
                                : !changeSeting_logo_upper
                                ? `/images/seting/${seting.data.site_upper_logo}`
                                : getUpperLogo()
                            "
                            alt="seting profile picture"
                          />
                          <span
                            class="text-danger"
                            v-if="seting.errors.site_upper_logo"
                          >
                            {{ seting.errors.site_upper_logo[0] }}</span
                          >
                        </div>
                      </div>

                      <div
                        v-if="
                          this.$store.getters.getPermissionsData.includes(
                            'ارفاق اللوجو السفلي للاعدادات'
                          )
                        "
                        class="avatar-upload mx-1"
                      >
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              accept=".png, .jpg, .jpeg"
                              @change="setSeting_lower_logo"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <img
                            title="Seting logo lower"
                            class="profile-seting-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !seting.data.site_lower_logo
                                ? '/images/test.png'
                                : !changeSeting_logo_lower
                                ? `/images/seting/${seting.data.site_lower_logo}`
                                : getLowerLogo()
                            "
                            alt="seting profile picture"
                          />
                          <span
                            class="text-danger"
                            v-if="seting.errors.site_lower_logo"
                          >
                            {{ seting.errors.site_lower_logo[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">عنوان الموقع</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_address ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_address"
                        />
                        <span
                          v-if="seting.errors.site_address"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_address[0] }}
                        </span>
                      </div>
                      <!-- site_phone -->
                      <div class="form-contole">
                        <label class="form-controle"> الموبيل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_phone ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_phone"
                        />
                        <span
                          v-if="seting.errors.site_phone"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_phone[0] }}
                        </span>
                      </div>
                      <!-- site_email -->
                      <div class="form-contole">
                        <label class="form-controle"> الايميل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_email ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_email"
                        />
                        <span
                          v-if="seting.errors.site_email"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_email[0] }}
                        </span>
                      </div>
                      <!-- site_name -->
                      <div class="form-contole">
                        <label class="form-controle"> اسم الموقع</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_name ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_name"
                        />
                        <span
                          v-if="seting.errors.site_name"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_name[0] }}
                        </span>
                      </div>
                      <!-- site_summary -->
                      <div class="form-contole">
                        <label class="form-controle"> الملخص</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_summary ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_summary"
                        />
                        <span
                          v-if="seting.errors.site_summary"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_summary[0] }}
                        </span>
                      </div>
                      <!-- site_slogan -->
                      <div class="form-contole">
                        <label class="form-controle"> الشعار</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_slogan ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_slogan"
                        />
                        <span
                          v-if="seting.errors.site_slogan"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_slogan[0] }}
                        </span>
                      </div>
                      <!-- site_facebook -->
                      <div class="form-contole">
                        <label class="form-controle"> الفيسبوك</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_facebook ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_facebook"
                        />
                        <span
                          v-if="seting.errors.site_facebook"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_facebook[0] }}
                        </span>
                      </div>
                      <!-- site_instegram -->
                      <div class="form-contole">
                        <label class="form-controle"> الفيسبوك</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_instegram ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_instegram"
                        />
                        <span
                          v-if="seting.errors.site_instegram"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_instegram[0] }}
                        </span>
                      </div>
                      <!-- site_tiktok -->
                      <div class="form-contole">
                        <label class="form-controle"> تيك توك</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_tiktok ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_tiktok"
                        />
                        <span
                          v-if="seting.errors.site_tiktok"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_tiktok[0] }}
                        </span>
                      </div>
                      <!-- site_youtube -->
                      <div class="form-contole">
                        <label class="form-controle"> يوتيوب</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_youtube ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_youtube"
                        />
                        <span
                          v-if="seting.errors.site_youtube"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_youtube[0] }}
                        </span>
                      </div>
                      <!-- site_snapchate -->
                      <div class="form-contole">
                        <label class="form-controle"> اسناب شات</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_snapchate ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_snapchate"
                        />
                        <span
                          v-if="seting.errors.site_snapchate"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_snapchate[0] }}
                        </span>
                      </div>
                      <!-- site_keywords -->
                      <div class="form-contole">
                        <label class="form-controle">
                          الكلمات المعبره عن الموقع مفصوله ب ,</label
                        >
                        <textarea
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_keywords ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_keywords"
                        ></textarea>
                        <span
                          v-if="seting.errors.site_keywords"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_keywords[0] }}
                        </span>
                      </div>
                      <!-- site_description -->
                      <div class="form-contole">
                        <label class="form-controle">
                          الوصف الخاص بالموقع</label
                        >
                        <textarea
                          autocomplete="on"
                          :class="[
                            'form-control',
                            seting.errors.site_description ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="seting.data.site_description"
                        ></textarea>
                        <span
                          v-if="seting.errors.site_description"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.site_description[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-label">التفعيل</label>
                        <select
                          aria-="true"
                          v-model="seting.data.site_active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="seting.errors.active"
                          class="invalid-feedback"
                        >
                          {{ seting.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      v-if="
                        this.$store.getters.getPermissionsData.includes(
                          'تعديل اعدادات الموقع'
                        )
                      "
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateSeting"
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  name: "setingDetails",
  data: () => {
    return {
      changeSeting_logo_lower: false,
      changeSeting_logo_upper: false,
      seting: {
        data: {
          id: "",
          site_address: "",
          site_phone: "",
          site_email: "",
          site_name: "",
          site_summary: "",
          site_slogan: "",
          site_facebook: "",
          site_instegram: "",
          site_tiktok: "",
          site_youtube: "",
          site_snapchate: "",
          site_keywords: "",
          site_description: "",
          site_upper_logo: "",
          site_lower_logo: "",
          site_active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update seting =======================
    updateSeting() {
      axios
        .post("/api/admin/seting/update", this.seting.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الاعدادات بنجاح",
            });
            this.seting.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.seting.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update seting =======================
    // ================= start part get seting  =======================
    getSeting() {
      axios
        .get("/api/admin/seting/index")
        .then((res) => {
          if (res.data.status == true) {
            this.seting.data = res.data.seting;
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
    // ================= end part get seting  =======================
    // ================= start part set seting icon  =======================
    setSiteUpperLogo(e) {
      this.seting.errors = {};
      this.changeSeting_logo_upper = true;
      this.seting.data.site_upper_logo = e.target.files[0];
      let formData = new FormData();
      formData.append("site_upper_logo", e.target.files[0]);
      axios
        .post("/api/admin/seting/upload/upper_logo", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل صوره اللوجو العلويه بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.seting.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set seting icon  =======================
    // ================= start part set seting image  =======================
    setSeting_lower_logo(e) {
      this.seting.errors = {};
      this.changeSeting_logo_lower = true;
      this.seting.data.site_lower_logo = e.target.files[0];
      let formData = new FormData();
      formData.append("site_lower_logo", e.target.files[0]);
      axios
        .post("/api/admin/seting/upload/lower_logo", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل صوره اللوجو السفليه بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.seting.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set seting image  =======================
    // ================= start part set image  =======================
    getLowerLogo() {
      return window.URL.createObjectURL(this.seting.data.site_lower_logo);
    },
    getUpperLogo() {
      return window.URL.createObjectURL(this.seting.data.site_upper_logo);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getSeting();
  },
};
</script>

<style lang="scss" scoped>
.profile-seting-img {
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
