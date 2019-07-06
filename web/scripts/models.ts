export interface IssueStatusList {
    [key: string]: {
        id: number
    }
}

export const IssueStatus: IssueStatusList = {
    UNDONE: {
        id: 0
    },
    DONE: {
        id: 1
    }
};