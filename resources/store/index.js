import { defineStore } from 'pinia'
import actions from './actions'
import state from './state'

//console.log(actions)
export const useAppStore = defineStore('app', {
    state,
    getters: {},
    actions,
    persist: true,
})
