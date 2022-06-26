import to from 'await-to-js'

export default async promise => {
  const [error, response] = await to(promise)
  return { error, response }
}