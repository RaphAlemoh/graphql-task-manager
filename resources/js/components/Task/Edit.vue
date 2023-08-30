<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Update Task
              <router-link :to="{ name: 'tasks' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
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
              <form @submit.prevent="updateTaskForm">
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
                      Update Task
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
import { TASK_QUERY, UPDATE_TASK } from "../../graphql/task";
import { reactive, ref, watch } from "vue";
import { useRoute } from "vue-router";

export default {
  setup() {
    const route = useRoute();
    const form = reactive({
      title: "",
      description: "",
      status: "",
      due_date: "",
    });

    const id = route.params.id;

    const { result, loading } = useQuery(TASK_QUERY, {
      id: id,
    });

    watch(() => {
      const data = result.value?.task ?? "";
      if (data) {
        form.title = data.title;
        form.description = data.description;
        form.status = data.status;
        form.due_date = data.due_date;
      }
    });

    const {
      mutate: updateTask,
      error,
      loading: createLoading,
    } = useMutation(UPDATE_TASK, () => ({
      update: (cache, { data: { updateTask } }) => {
        let data = cache.readQuery({ query: TASK_QUERY });
        let updated_data = data.tasks.map((task) => {
          if (task.id == updateTask.id) {
            return updateTask;
          }
          return task;
        });
        data = {
          tasks: { data: updated_data, __typename: data.tasks.__typename },
        };

        cache.writeQuery({ query: TASK_QUERY, data });
      },
    }));

    const updateTaskForm = () => {
      let data = {
        title: form.title,
        description: form.description,
        status: form.status,
        due_date: form.due_date,
      };
      updateTask(data);
      resetForm();
    };

    const resetForm = () => {
      form.title = "";
      form.description = "";
      form.status = "";
      form.due_date = "";
    };

    return {
      result,
      loading,
      error,
      createLoading,
      form,
      updateTaskForm,
    };
  },
};
</script>

<style></style>
