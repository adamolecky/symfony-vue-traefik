<template>
  <div>
    <div class="row col">
      <section v-if="errored">
        <p>We're sorry, we're not able to retrieve this information at the moment, please try back later</p>
      </section>

      <section v-else>
        <div v-if="loading">
          Loading...
        </div>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">
                #
              </th>
              <th scope="col">
                Full Name
              </th>
              <th scope="col">
                Email
              </th>
              <th scope="col">
                Password
              </th>
              <th scope="col">
                Role
              </th>
            </tr>
          </thead>

          <tbody
            v-for="item in data"
            :key="item"
          >
            <tr>
              <td class="column">
                {{ item.id }}
              </td>
              <td class="column">
                {{ item.fullName }}
              </td>
              <td class="column">
                {{ item.email }}
              </td>
              <td class="column">
                {{ item.password }}
              </td>
              <td class="column">
                {{ item.role }}
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "List",
  data () {
    return {
      data: null,
      loading: true,
      errored: false
    }
  },
  mounted () {
    axios
      .get('http://app.localhost/api/user/list')
      .then(response => {
        this.data = response.data
      })
      .catch(error => {
        console.log(error)
        this.errored = true
      })
      .finally(() => this.loading = false)
  }
};
</script>

<style>
  .column {
      margin: 20px;
  }

</style>