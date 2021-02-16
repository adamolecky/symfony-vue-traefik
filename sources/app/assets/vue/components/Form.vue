<template>
  <div class="hello">
    <h1>Store new user</h1>
    <FormulateForm
      v-model="formValues"
      @submit="handleSubmit"
    >
      <FormulateInput
        name="fullName"
        label="Name"
        validation="required"
      />
      <FormulateInput
        name="email"
        label="Email"
        validation="required|email"
      />
      <FormulateInput
        type="password"
        name="password"
        label="Password"
        validation="required"
      />
      <FormulateInput
        name="roleString"
        label="Role"
        type="select"
        :options="{admin: 'Admin', user: 'User'}"
      />
      <FormulateInput
        type="submit"
        label="Sign up"
      />
    </FormulateForm>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    formValues: {}
  }),
  methods: {
    handleSubmit() {
      const config = {
        headers:
            {
              "Accept": "application/json",
              "Content-Type": "application/json",
              "Access-Control-Allow-Origin": '*',
              "Access-Control-Allow-Methods": 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
              "Access-Control-Allow-Headers": 'Origin, Content-Type, X-Auth-Token, Accept',
              "Access-Control-Max-Age": "1728000",
            }
      };
      axios.post('http://app.localhost/api/user/create', this.formValues, config).then(()=>alert('Saved!')).catch(error => console.log(error))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.formulate-input {
  margin: 35px auto;
  width: 300px;
}

</style>
