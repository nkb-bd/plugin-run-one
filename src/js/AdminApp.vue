<template>
  <div class="plugin_run_one_card">
    <el-menu class="el-menu-demo" mode="horizontal">
      <div class="nav">
        <ul class="cc-inline-list">
          <router-link
            tag="li"
            v-for="menuItem in topMenus"
            :key="menuItem.route"
            active-class="ninja-tab-active"
            exact
            :class="['ninja-tab el-menu-item']"
            :to="{ name: menuItem.route }"
          >
            {{ menuItem.title }}
          </router-link>
        </ul>
      </div>
    </el-menu>

    <div v-if="visibleWarning == true">
      <el-alert title="Enable the module first !" type="warning"> </el-alert>
    </div>

    <router-view @updateMenu="getModules"></router-view>
  </div>
</template>

<script>
export default {
  name: "AdminApp",
  data() {
    return {
      topMenus: [],
      visibleWarning: false,
      modules: ""
    };
  },
  methods: {
    setTopmenu() {
      this.topMenus = [];
    },
    test() {
      this.topMenus.pop();
    },

    getModules() {
      this.$adminGet({
        route: "get_modules"
      }).then(response => {
        // chceking modules from wp_options
        let modules = Object.values(response.data.data);
        this.topMenus = modules;
        let test = {
          route: "dashboard",
          title: "Dashboard "
        };
        this.topMenus.unshift(test);
        this.routerCheck();
      });
    },
    routerCheck() {
      this.$adminGet({
        route: "get_modules_db"
      }).then(res => {
        this.modules = res.data.data;
      });
      this.$router.beforeEach((to, from, next) => {
        let name = to.name;

        // check if modules saved in db

        if (this.modules[name] === "true" || name == "dashboard") {
          next();
          this.visibleWarning = false;
        } else {
          this.visibleWarning = true;
          next({ name: "dashboard" });
        }
      });
    }
  },
  mounted() {
    this.setTopmenu();
    this.getModules();

    let test = {
      route: "dashboard",
      title: "Dashboard "
    };
    this.topMenus.unshift(test);

    // this.$router.options.routes.forEach(route => {
    //
    // })
  }
};
</script>

<style>
.plugin_run_one_card {
  margin-left: -20px;
}
.ninja-tab-active {
  background-color: #3a8ee6;
  color: #ffffff;
}
.cc-inline-list li {
  float: left;
  margin: 5px;
}
.text-center {
  margin: 0 auto;
  text-align: center;
}
.cc-main-container .el-dialog__body {
  padding: 20px 20px;
}

.cc-main-container .pull-right {
  float: right;
}
pre.prettyprint {
  margin-left: 0;
}

.cc-main-container .el-tabs--left .el-tabs__header.is-left {
  min-width: 135px !important;
}
</style>
