<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Create Task
              <router-link :to="{ name: 'tasks' }" class="float-right"
                >Back</router-link
              >
            </div>
            <div v-if="error">
              <span v-for="(err, i) of error.graphQLErrors" :key="i">
                <ul v-if="err.extensions.validation">
                  <li
                    v-for="(message, index) of err.extensions.validation"
                    :key="index"
                    class="text-danger"
                  >
                    {{ message[0] }}
                  </li>
                </ul>
              </span>
            </div>

            <div class="card-body">
              <form @submit.prevent="saveForm">
                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Name</label
                  >
                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.title"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Description</label
                  >
                  <div class="col-md-6">
                    <textarea
                      v-model="form.description"
                      type="text"
                      class="form-control"
                      id="description"
                      cols="30"
                      rows="10"
                      required
                    ></textarea>
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Due Date</label
                  >
                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.due_date"
                      type="date"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Status</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      v-model="form.status"
                      aria-label="Task status"
                    >
                      <option value="not started">Not Started</option>
                      <option value="in progress">In Progress</option>
                      <option value="completed">Completed</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row mb-0 mt-4">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      Create
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useQuery, useMutation } from "@vue/apollo-composable";
import { TASKS_QUERY, CREATE_TASK } from "../../graphql/task";
import { reactive, ref } from "vue";

export default {
  setup() {
    const form = reactive({
      title: "",
      description: "",
      status: "",
      due_date: "",
    });

    const {
      mutate: createTask,
      error,
      loading: createLoading,
    } = useMutation(CREATE_TASK, () => ({
      update: (cache, { data: { createTask } }) => {
        let data = cache.readQuery({ query: TASKS_QUERY });
        data = {
          ...data,
          tasks: {
            data: [...data.tasks, createTask],
            __typename: data.tasks.__typename,
          },
        };
        cache.writeQuery({ query: TASKS_QUERY, data });
      },
    }));

    const saveForm = () => {
      let data = {
        title: form.title,
        description: form.description,
        status: form.status,
        due_date: form.due_date,
      };
      createTask(data);
      resetForm();
    };
    const resetForm = () => {
      form.title = "";
      form.description = "";
      form.status = "";
      form.due_date = "";
    };

    return {
      form,
      saveForm,
      error,
      createLoading,
    };
  },
};
</script>
