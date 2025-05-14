export const generateOrderId = (): string => {
  const timestamp = Date.now()
  const randomPart = Math.random().toString(36).substring(2, 8).toUpperCase()
  return `ORD-${timestamp}-${randomPart}`
}

export const moveItem = <T>(array: T[], fromIndex: number, toIndex: number): T[] => {
  const newArray = [...array]
  const item = newArray.splice(fromIndex, 1)[0]
  newArray.splice(toIndex, 0, item)
  return newArray
}
