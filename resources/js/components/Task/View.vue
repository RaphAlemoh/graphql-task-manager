<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card text-center">
            <div class="card-header">My Task Title</div>
            <div v-if="loading" class="text-center">Loading...</div>
            <div class="card-body" v-else-if="result && result.task">
              <h5 class="card-title">{{ result.task.title }}</h5>
              <p class="card-text">
                {{ result.task.description }}
              </p>
              <router-link :to="{ name: 'tasks' }" class="btn btn-primary"
                >Back</router-link
              >
            </div>
            <div class="card-footer text-muted">
              Due Date {{ result.task.due_date }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import { useQuery } from "@vue/apollo-composable";
import { TASK_QUERY } from "../../graphql/task";
import { useRoute } from "vue-router";

export default {
  setup() {
    const route = useRoute();

    const id = route.params.id;

    const { result, loading } = useQuery(TASK_QUERY, {
      id: id,
    });

    return {
      result,
      loading,
    };
  },
};
</script>
  
  <style></style>
  