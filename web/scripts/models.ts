export interface IssueStatusList {
    [key: string]: {
        id: number,
        name: string,
        checked: boolean,
        icon: {
            // Иконки берутся из набора semantic ui. Указывается только имя класса
            // иконки, без слова `icon`
            name: string,
            // Предопределяется в CSS.
            color: string
        },
        menu: {
            // Иконка из того же semantic ui для показа ее в контекстном меню при
            // выборе статуса задачи.
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
            icon: 'circle outline'
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
            icon: 'check circle outline'
        }
    },
    IN_PROCESS: {
        id: 2,
        name: 'В процессе',
        checked: false,
        icon: {
            name: 'flag',
            color: 'blue'
        },
        menu: {
            icon: 'flag outline'
        }
    },
    POSTPONED: {
        id: 3,
        name: 'Отложено',
        checked: true,
        icon: {
            name: 'history',
            color: 'yellow'
        },
        menu: {
            icon: 'history'
        }
    },
    REJECTED: {
        id: 4,
        name: 'Отменено',
        checked: true,
        icon: {
            name: 'times',
            color: 'red'
        },
        menu: {
            icon: 'times circle outline'
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