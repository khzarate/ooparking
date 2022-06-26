import useAsync from '../composables/useAsync'

export default async (schema, data) => {
  const { error } = await useAsync(schema
    .validate(data, { abortEarly: false }))

  const formErrors = {};

  await error?.inner?.forEach(async (errorPromise) => {
    const error = await errorPromise
    formErrors[error.path] = error.errors[0]
  });

  return formErrors;
}