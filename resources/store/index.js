import { defineStore } from 'pinia'
import actions from './actions'
import state from './state'
import getters from './getters'

//console.log(actions)
export const useAppStore = defineStore('app', {
    state,
    getters,
    actions,
    persist: true,
})
