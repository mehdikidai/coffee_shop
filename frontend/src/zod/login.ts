import { z } from 'zod'

export const LOGIN = z.object({
  email: z.string().email(),
  password: z.string().min(8),
  tenantToken: z.string().min(4)
})

export const KEY = z.string().min(8).max(64)
