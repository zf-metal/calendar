import {LOADING_LESS, LOADING_PLUS, SHOW_ERROR, HIDE_ERROR, SET_TEXT_ERROR} from "./helpers-mutations";
import {SET_PRE_EVENT_SIZE} from "../mutation-types";


export default {
    namespaced: false,
    state: {
        loading: 0,
        showError: 0,
        textError: "error",
    },
    actions: {

        loadingPlus({commit}) {
            commit(LOADING_PLUS);
        },

        loadingLess({commit}) {
            commit(LOADING_LESS);
        },

        showError({commit}) {
            commit(SHOW_ERROR);
        },

        hideError({commit}) {
            commit(HIDE_ERROR);
        },

        setTextError: {
            root: true,
            handler({commit}, text) {
                commit(SET_TEXT_ERROR, text);
                commit(SHOW_ERROR);
            }
        }

    },
    mutations: {
        [SHOW_ERROR](state) {
            state.showError = true
        }
        ,
        [HIDE_ERROR](state) {
            state.showError = false
        }
        ,
        [SET_TEXT_ERROR](state, text) {
            state.textError = text;
        }
        ,
        [LOADING_PLUS](state) {
            state.loading++
        }
        ,
        [LOADING_LESS](state) {
            state.loading--
        }
        ,
    }
    ,

    getters: {
        getLoading: state => {
            return state.loading;
        },


        getShowError:
            state => {
                return state.showError;
            },

        getTextError:
            state => {
                return state.textError;
            },

    }
}
