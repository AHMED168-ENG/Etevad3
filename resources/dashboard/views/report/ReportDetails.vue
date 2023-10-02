<template>
  <div class="report">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prreportDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات التقرير
                    </h4>
                    <section class="content">
                      <div class="avatar-upload">
                        <div class="avatar-edit">
                          <form action="" method="post" id="form-image">
                            <input
                              type="file"
                              id="imageUpload"
                              @change="setPdf"
                            />
                            <label for="imageUpload"
                              ><i class="las la-pen"></i
                            ></label>
                          </form>
                        </div>
                        <div class="avatar-preview">
                          <div
                            class="profile-report-img img-responsive img-circle"
                          ></div>
                          <span class="text-danger" v-if="report.errors.image">
                            {{ report.errors.image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">عنوان التقرير</label>
                        <input
                          type="text"
                          :class="[
                            'form-control',
                            report.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="report.data.title"
                        />

                        <span
                          v-if="report.errors.title"
                          class="invalid-feedback"
                        >
                          {{ report.errors.title[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-controle">تاريخ التقرير</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            report.errors.report_date ? 'is-invalid' : '',
                          ]"
                          type="date"
                          v-model="report.data.report_date"
                        />
                        <span
                          v-if="report.errors.report_date"
                          class="invalid-feedback"
                        >
                          {{ report.errors.report_date[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">محتوي التقرير</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            report.errors.overview ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="report.data.overview"
                          :config="editorConfig"
                        ></ckeditor>
                        <span
                          v-if="report.errors.overview"
                          class="invalid-feedback"
                        >
                          {{ report.errors.overview[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="report.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="report.errors.active"
                          class="invalid-feedback"
                        >
                          {{ report.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateReport"
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
  name: "reportDetails",
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
      report: {
        data: {
          id: "",
          title: "",
          report_date: "",
          overview: "",
          active: 1,
          pdf: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update report =======================
    updateReport() {
      axios
        .put(
          "/api/admin/report/update/" + this.report.data.id,
          this.report.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات التقرير بنجاح",
            });
            this.report.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.report.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update report =======================
    // ================= start part get report  =======================
    getReport() {
      axios
        .get("/api/admin/report/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.report.data = res.data.report;
            this.report.data.report_date = moment(
              this.report.data.report_date
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
    // ================= end part get report  =======================
    // ================= start part set image  =======================
    setPdf(e) {
      this.report.errors = {};
      this.changeImage = true;
      this.report.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("pdf", e.target.files[0]);
      axios
        .post(
          "/api/admin/report/upload/pdf/" + this.$route.params.id,
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "تم تعديل الملف بنجاح",
          });
          if (res.data.status == true) {
          } else if (res.data.status == false) {
            this.report.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.report.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getReport();
  },
};
</script>

<style lang="scss" scoped>
.profile-report-img {
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
