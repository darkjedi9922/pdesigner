export interface IssueStatusList {
    [key: string]: {
        id: number,
        name: string,
        checked: boolean,
        icon: {
            name: string,
            color: 'empty' | 'green'
        },
        menu: {
            icon: string
        }
    }
}

export const IssueStatus: IssueStatusList = {
    UNDONE: {
        id: 0,
        name: 'Невыполнено',
        checked: false,
        icon: {
            name: '',
            color: 'empty',
        },
        menu: {
            icon: 'calendar outline'
        }
    },
    DONE: {
        id: 1,
        name: 'Выполнено',
        checked: true,
        icon: {
            name: 'check',
            color: 'green'
        },
        menu: {
            icon: 'calendar check outline'
        }
    }
};

// Временный костыль.
export function findStatusById(id: number): string
{
    for (const key in IssueStatus) {
        if (IssueStatus.hasOwnProperty(key)) {
            const status = IssueStatus[key];
            if (status.id == id) return key;
        }
    }
    throw 'The status id not found';
}