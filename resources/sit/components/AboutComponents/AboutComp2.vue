<template>
  <div class="row justify-content-center mt-5" style="margin-bottom: 200px">
    <div class="col-6 col-md-3 mb-5" v-for="director in directors.data">
      <div class="card border-0" style="background:none !important">
        <div
          class=""
          style="
            position: relative;
            background: #b2e3ff;
            border-radius: 16px;
            border: none;
          "
        >
          <img style="width:100%;height:280px" :src="'./images/directors/' + director.image" />
        </div>
        <div class="tit">
          <div
            style="
              text-align: center;
              color: #306386;

              font-family: Cairo;
              font-weight: 400;
              line-height: 32px;
              word-wrap: break-word;
            "
          >
            {{ director.title + " / " + director.name }}
          </div>
        </div>

        <div class="mt-4">{{ director.jop }}</div>
      </div>
    </div>
    <VPagination
    v-model="page"
    :pages="directors.last_page"
    :range-size="1"
    active-color="#DCEDFF"
    align="center"
    @update:modelValue="getDirectors"
  ></VPagination>
  </div>

</template>

<script>
export default {
  data() {
    return {  
      page: 1,
      directors : {},
    }
  },
  methods : {
    getDirectors(page = this.page) {
      axios
        .get("/director/activeDirectors?page=" + page)
        .then((res) => {
          if (res.data.status == true) {
            this.directors = res.data.directors;
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
  },
  created() {
    this.getDirectors()
  }
};
</script>

<style scoped>
.Pagination {
  justify-content: center;
}
.card {
    background: none !important;
}
.tit {
  position: absolute;
  width: 90%;
  padding-left: 40px;
  padding-right: 40px;
  padding-top: 4px;
  padding-bottom: 4px;
  background: white;
  border-radius: 24px;
  justify-content: center;
  align-items: center;
  gap: 16px;
  top: 270px;
  margin-right: 10px;
  box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
}
@media only screen and (min-width: 380px) and (max-width: 767px) {
  .tit {
    padding-left: 0px;
    padding-right: 0px;
    position: absolute;
    width: 100% !important;
    font-size: 10px !important;
    background: white;
    border-radius: 24px;
    justify-content: center;
    align-items: center;
    gap: 16px;
    top: 210px !important;
    margin-right: 1px;
    box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
  }
}
@media only screen and (max-width: 380px) {
  .tit {
    padding-left: 0px;
    padding-right: 0px;
    position: absolute;
    width: 100% !important;
    font-size: 10px !important;
    background: white;
    border-radius: 24px;
    justify-content: center;
    align-items: center;
    gap: 16px;
    top: 120px;
    margin-right: 1px;
    box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
  }
  .tex {
    font-size: 16px !important;
  }
}
</style>