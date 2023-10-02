<template>
  <div>
    <Header />
    <Reports />
    <Footer />
  </div>
</template>
<script>
import Header from "../components/Layout/NavBar.vue";
import Footer from "../components/Layout/FooterSec.vue";
import Reports from "../components/ReportsComponents/ReportCom.vue";

export default {
  components: {
    Header,
    Footer,
    Reports,
  },
};
</script>
