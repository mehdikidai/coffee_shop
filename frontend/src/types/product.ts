export interface CartProduct {
  id: number
  name: string
  price: number
  photo: string
  quantity: number
}

export interface Product {
  id: number
  name: string
  price: number
  photo: string
  categoryId: number
}

export interface Categories {
  id: number
  name: string
  icon: string
}
