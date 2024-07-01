import { inject } from "vue";
export function useGlobal(){
    const globalVariables = inject('globalVariables');
    if(!globalVariables){
        throw new Error('Global Variables not found');
    }
    return globalVariables;
}
