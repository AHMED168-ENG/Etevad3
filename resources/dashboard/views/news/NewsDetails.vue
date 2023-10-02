<template>
  <div class="news">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prnewsDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الخبر
                    </h4>
                    <section class="content">
                      <div class="avatar-upload">
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
                            class="profile-news-img img-responsive img-circle"
                            id="imagePreview"
                            :src="
                              !news.data.image
                                ? '/images/test.png'
                                : !changeImage
                                ? `/images/news/${news.data.image}`
                                : getImageFile()
                            "
                            alt="news profile picture"
                          />
                          <span class="text-danger" v-if="news.errors.image">
                            {{ news.errors.image[0] }}</span
                          >
                        </div>
                      </div>

                      <!-- /.row -->
                    </section>
                    <br />
                    <div>
                      <div class="form-contole">
                        <label class="form-controle">عنوان الخير</label>
                        <input
                          type="text"
                          :class="[
                            'form-control',
                            news.errors.title ? 'is-invalid' : '',
                          ]"
                          v-model="news.data.title"
                        />

                        <span v-if="news.errors.title" class="invalid-feedback">
                          {{ news.errors.title[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-controle">تاريخ الخير</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            news.errors.news_date ? 'is-invalid' : '',
                          ]"
                          type="date"
                          v-model="news.data.news_date"
                        />
                        <span
                          v-if="news.errors.news_date"
                          class="invalid-feedback"
                        >
                          {{ news.errors.news_date[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">محتوي الخير</label>
                        <ckeditor
                          :class="[
                            'form-control',
                            news.errors.full_description ? 'is-invalid' : '',
                          ]"
                          :editor="editor"
                          v-model="news.data.full_description"
                          :config="editorConfig"
                        ></ckeditor>
                        <span
                          v-if="news.errors.full_description"
                          class="invalid-feedback"
                        >
                          {{ news.errors.full_description[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle"
                          >الوصف الخاص بالصفحه (سيو)</label
                        >
                        <textarea
                          autocomplete="on"
                          :class="[
                            'form-control',
                            news.errors.page_description ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="news.data.page_description"
                        ></textarea>
                        <span
                          v-if="news.errors.page_description"
                          class="invalid-feedback"
                        >
                          {{ news.errors.page_description[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-controle"
                          >الكلمات الوصفيه الخاص بالصفحه مفصوله , (سيو)</label
                        >
                        <textarea
                          autocomplete="on"
                          :class="[
                            'form-control',
                            news.errors.page_keywords ? 'is-invalid' : '',
                          ]"
                          type="text"
                          v-model="news.data.page_keywords"
                        ></textarea>
                        <span
                          v-if="news.errors.page_keywords"
                          class="invalid-feedback"
                        >
                          {{ news.errors.page_keywords[0] }}
                        </span>
                      </div>

                      <div v-if="!news.edit" class="form-contole">
                        <label class="form-label">الحاله </label>
                        <select
                          v-model="news.data.active"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1" selected>مفعل</option>
                          <option value="0">غير مفعل</option>
                        </select>
                        <span
                          v-if="news.errors.active"
                          class="invalid-feedback"
                        >
                          {{ news.errors.active[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateNews"
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
  name: "newsDetails",
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
      news: {
        data: {
          title: "",
          id: "",
          news_date: "",
          full_description: "",
          active: 1,
          page_description: "",
          page_keywords: "",
          image: "",
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update news =======================
    updateNews() {
      axios
        .put("/api/admin/news/update/" + this.news.data.id, this.news.data)
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الخبر بنجاح",
            });
            this.news.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.news.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update news =======================
    // ================= start part get news  =======================
    getNews() {
      axios
        .get("/api/admin/news/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.news.data = res.data.news;
            this.news.data.news_date = moment(this.news.data.news_date).format(
              "YYYY-MM-DD"
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
    // ================= end part get news  =======================
    // ================= start part set image  =======================
    setImage(e) {
      this.news.errors = {};
      this.changeImage = true;
      this.news.data.image = e.target.files[0];
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(
          "/api/admin/news/upload/file/" + this.$route.params.id,
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
            this.news.errors = res.data.errors;
          } else {
          }
        });
    },
    // ================= end part set image  =======================
    // ================= start part set image  =======================
    getImageFile() {
      return window.URL.createObjectURL(this.news.data.image);
    },
    // ================= end part set image  =======================
  },
  created() {
    this.getNews();
  },
};
</script>

<style lang="scss" scoped>
.profile-news-img {
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
