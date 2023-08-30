import gql from 'graphql-tag'

export const TASKS_QUERY = gql`
    query tasks {
        tasks {
            id
            title
            description
            status
            due_date
            category {
              id
              name
            }
            user{
              name
            }
          }
    }
`

export const TASK_QUERY = gql`
    query task ($id : ID!) {
        task (id : $id){
            id
            title
            description
            status
            due_date
            category {
              id
              name
            }
          }
    }
`

export const CREATE_TASK = gql`
  mutation createTask(
    $title: String!
    $description: String!
    $status: String!
    $due_date: Date
  ) {
    createTask (input:{
        title: $title
        description: $description
        status: $status
        due_date: $due_date
    }) {
      id
      title
      description
      status
      due_date
      category {
        id
        name
      }
    }
    
  }
`

export const UPDATE_TASK = gql`
  mutation updateTask(
    $id : ID!
    $title: String!
    $description: String!
    $status: String!
    $due_date: Date
  ) {
    updateTask (input:{
        id : $id
        title: $title
        description: $description
        status: $status
        due_date: $due_date
    }) {
      id
      title
      description
      status
      due_date
      category {
        id
        name
      }
    }
  }
`

export const DELETE_TASK = gql`
  mutation deleteTask ($id : ID!) {
    deleteTask (id : $id) {
      id
      title
      description
    }
  }
`

export const FILTER_TASKS = gql`
  query filterUserTasks ($status : String!) {
    filterUserTasks (status : $status) {
        id
        title
        description
        status
        due_date
        category {
          id
          name
        }
        user{
          name
        }
    }
  }
`