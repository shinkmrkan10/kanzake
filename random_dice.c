/*   rdice.c   */
/*   擬似乱数を用いてサイコロを振る   */

#include<stdio.h>
#include<stdlib.h>

int main(void)
{
    int i, j, die_one ;

/*   サイコロの出目を表示する   */

    srand(100);

    for( i=0 ; i<6 ; i++ ){
        die_one = rand()%6+1;
        printf("%2d", die_one);
        printf("\n");
    }

    return 0;
}