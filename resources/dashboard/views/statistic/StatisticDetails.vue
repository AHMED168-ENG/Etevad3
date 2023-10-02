<template>
  <div class="statistic">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prstatisticDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الاحصاء
                    </h4>

                    <div>
                      <div class="form-contole">
                        <label class="form-controle">اسم الاحصاء</label>
                        <textarea
                          name=""
                          id=""
                          :class="[
                            'form-control',
                            statistic.errors.statistic_name ? 'is-invalid' : '',
                          ]"
                          v-model="statistic.data.statistic_name"
                        ></textarea>
                        <span
                          v-if="statistic.errors.statistic_name"
                          class="invalid-feedback"
                        >
                          {{ statistic.errors.statistic_name[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-controle">عدد الاحصاء</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            statistic.errors.statistic_count
                              ? 'is-invalid'
                              : '',
                          ]"
                          type="number"
                          v-model="statistic.data.statistic_count"
                        />
                        <span
                          v-if="statistic.errors.statistic_count"
                          class="invalid-feedback"
                        >
                          {{ statistic.errors.statistic_count[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="statistic.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="statistic.errors.active"
                          class="invalid-feedback"
                        >
                          {{ statistic.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateStatistic"
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
  name: "statisticDetails",
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
      statistic: {
        data: {
          id: "",
          title: "",
          statistic_date: "",
          video_id: "",
          active: 1,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update statistic =======================
    updateStatistic() {
      axios
        .put(
          "/api/admin/statistic/update/" + this.statistic.data.id,
          this.statistic.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الاحصاء بنجاح",
            });
            this.statistic.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.statistic.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update statistic =======================
    // ================= start part get statistic  =======================
    getStatistic() {
      axios
        .get("/api/admin/statistic/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.statistic.data = res.data.statistic;
            this.statistic.data.statistic_date = moment(
              this.statistic.data.statistic_date
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
    // ================= end part get statistic  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.statistic.errors = {};
      this.changeImage = true;
      this.statistic.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/statistic/upload/file/" + this.$route.params.id,
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
            this.statistic.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.statistic.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getStatistic();
  },
};
</script>

<style lang="scss" scoped>
.profile-statistic-img {
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
