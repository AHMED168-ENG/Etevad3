<template>
  <div class="coverage">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prcoverageDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات التغطيه
                    </h4>
                    <div>
                      <iframe
                        width="100%"
                        height="520"
                        :src="
                          'https://www.youtube.com/embed/' +
                          coverage.data.video_id
                        "
                      >
                      </iframe>
                    </div>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">عنوان التغطيه</label>
                        <textarea
                          :class="[
                            'form-control',
                            coverage.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="coverage.data.title"
                        ></textarea>
                        <span
                          v-if="coverage.errors.title"
                          class="invalid-feedback"
                        >
                          {{ coverage.errors.title[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">تاريخ التغطيه</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            coverage.errors.coverage_date ? 'is-invalid' : '',
                          ]"
                          type="date"
                          v-model="coverage.data.coverage_date"
                        />
                        <span
                          v-if="coverage.errors.coverage_date"
                          class="invalid-feedback"
                        >
                          {{ coverage.errors.coverage_date[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle"
                          >الفيديو الخاص بالتغطيه (id)</label
                        >
                        <textarea
                          autocomplete="on"
                          :class="[
                            'form-control',
                            coverage.errors.video_id ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="coverage.data.video_id"
                        ></textarea>
                        <span
                          v-if="coverage.errors.video_id"
                          class="invalid-feedback"
                        >
                          {{ coverage.errors.video_id[0] }}
                        </span>
                      </div>

                      <div v-show="coverage.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="coverage.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="coverage.errors.active"
                          class="invalid-feedback"
                        >
                          {{ coverage.errors.active[0] }}
                        </span>
                      </div>

                      <div v-if="!coverage.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="coverage.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1" selected>مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="coverage.errors.active"
                          class="invalid-feedback"
                        >
                          {{ coverage.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateCoverage"
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
  name: "coverageDetails",
  data: () => {
    return {
      editor: ClassicEditor,
      editorData: "",
      editorConfig: {
        toolbar: [
          "heading",
          "|",
          "bold",
          "italic",
          "link",
          "bulletedList",
          "numberedList",
          "blockQuote",
        ],
        heading: {
          options: [
            {
              model: "paragraph",
              title: "Paragraph",
              class: "ck-heading_paragraph",
            },
            {
              model: "heading1",
              view: "h1",
              title: "Heading 1",
              class: "ck-heading_heading1",
            },
            {
              model: "heading2",
              view: "h2",
              title: "Heading 2",
              class: "ck-heading_heading2",
            },
          ],
        },
      },
      changeImage: false,
      coverage: {
        data: {
          id: "",
          title: "",
          coverage_date: "",
          video_id: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update coverage =======================
    updateCoverage() {
      axios
        .put(
          "/api/admin/coverage/update/" + this.coverage.data.id,
          this.coverage.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات التغطيه بنجاح",
            });
            this.coverage.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.coverage.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update coverage =======================
    // ================= start part get coverage  =======================
    getCoverage() {
      axios
        .get("/api/admin/coverage/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.coverage.data = res.data.coverage;
            this.coverage.data.coverage_date = moment(
              this.coverage.data.coverage_date
            ).format("YYYY-MM-DD");
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
    // ================= end part get coverage  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.coverage.errors = {};
      this.changeImage = true;
      this.coverage.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/coverage/upload/file/" + this.$route.params.id,
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
            this.coverage.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.coverage.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getCoverage();
  },
};
</script>

<style lang="scss" scoped>
.profile-coverage-img {
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
