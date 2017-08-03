<template>
    <v-app>
    <div v-if="$auth.ready() && loaded">
        <v-navigation-drawer
          temporary
          v-model="drawer"
          :mini-variant="mini"
          dark
          overflow
          absolute
        >

        <v-list v-show="!$auth.check()">
            <router-link :to="{name: 'login'}">login</router-link> &bull;
            <router-link :to="{name: 'register'}">register</router-link> &bull;
            <router-link :to="{name: 'oauth1'}">oauth1</router-link> &bull;
            <router-link :to="{name: 'oauth2'}">oauth2</router-link>
        </v-list>

          <v-list class="pa-0">
            <v-list-tile v-if="mini" @click.native.stop="mini = !mini">
              <v-list-tile-action>
                <v-icon light>chevron_right</v-icon>
              </v-list-tile-action>
            </v-list-tile>
            <v-list-tile avatar tag="div">
              <v-list-tile-avatar>
                <img src="https://randomuser.me/api/portraits/men/85.jpg" />
              </v-list-tile-avatar>
              <v-list-tile-content>
                <v-list-tile-title>John Leider</v-list-tile-title>
              </v-list-tile-content>
              <v-list-tile-action>
                <v-btn icon @click.native.stop="mini = !mini">
                  <v-icon>chevron_left</v-icon>
                </v-btn>
              </v-list-tile-action>
            </v-list-tile>
          </v-list>
          <v-list class="pt-0" dense>
            <v-divider light></v-divider>
            <v-list-tile v-for="item in items" :key="item.title" :to="item.route">
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-navigation-drawer>

        <v-toolbar fixed dark>
          <v-toolbar-side-icon @click.native.stop="drawer = !drawer"></v-toolbar-side-icon>
          <v-toolbar-title>Toolbar</v-toolbar-title>
        </v-toolbar>

        </div>

        <main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </main>
    </v-app>
</template>

<script>
  export default {
    data () {
      return {
        drawer: null,
        items: [
          { title: 'Home', icon: 'dashboard', route: 'home' },
          { title: 'Users', icon: 'question_answer', route: 'users' }
        ],
        mini: false,
        right: null
      }
    }
  }
</script>