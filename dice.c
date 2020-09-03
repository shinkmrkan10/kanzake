/*   dice.c   */
/*   サイコロを振って出た目の統計を取る   */

#include<stdio.h>
#include<stdlib.h>

#define SEED_ONE 215             /*   サイ１の乱数シード   */
#define SEED_TWO 216             /*   サイ２の乱数シード   */
#define TOTAL_NUMBER 216*216     /*   試技数　　　　　　   */
#define COLUMN_NUMBER 24         /*   １列あたりの表示数   */
#define ROW_NUMBER 9             /*   表示行数　　　　　   */

int main(void)
{
    int i, j, sum, sum1, sum2 ;
    int die_one[TOTAL_NUMBER];   /*   サイ１の出目　　　   */
    int die_two[TOTAL_NUMBER];   /*   サイ２の出目　　　   */
    int even_odd[TOTAL_NUMBER];  /*   丁半（偶数奇数）　   */
    int cross_sum[6][6]={0};     /*   出目の集計表　　　   */
    int sequence_one[6][6]={0};  /*   サイ１の推移表　　   */
    int sequence_two[6][6]={0};  /*   サイ２の推移表　　   */

/*   サイ１の出目を配列に格納する   */

    srand(SEED_ONE);

    for( i=0 ; i<TOTAL_NUMBER ; i++ ){
        die_one[i] = rand()%6+1;
    }

/*   サイ２の出目を配列に格納する   */

    srand(SEED_TWO);

    for( i=0 ; i<TOTAL_NUMBER ; i++ ){
        die_two[i] = rand()%6+1;
    }

/*   丁半の結果を０１で配列に格納する   */

    for( i=0 ; i<TOTAL_NUMBER ; i++ ){
        even_odd[i] = (die_one[i]+die_two[i])%2;
    }

/*   指定した行数列数までの出目を表示する   */

    printf("\nThe result of 1=>%3d\n", ROW_NUMBER*COLUMN_NUMBER);
    printf("die1 seed=%d : die2 seed=%d\n\n", SEED_ONE, SEED_TWO );
    for( j=0 ; j<ROW_NUMBER ; j++ ){
        printf("%3d=>%3d\n", j*COLUMN_NUMBER+1, (j+1)*COLUMN_NUMBER);
        printf("die_one :");
        for( i=0 ; i<COLUMN_NUMBER ; i++ ){
            printf("%2d", die_one[j*ROW_NUMBER+i]);
        }
        printf("\n");

        printf("die_two :");
        for( i=0 ; i<COLUMN_NUMBER ; i++ ){
            printf("%2d", die_two[j*ROW_NUMBER+i]);
        }
        printf("\n");

        printf("even/odd:");
        sum = 0;
        for( i=0 ; i<COLUMN_NUMBER ; i++ ){
            printf("%2d", even_odd[j*ROW_NUMBER+i]);
            sum+=even_odd[j*ROW_NUMBER+i];
        }
        printf(" : %2d/%2d\n", COLUMN_NUMBER-sum, sum);

        printf("\n");
    }

/*   出目の集計表を表示する   */

    printf("\nThe trial of %d\n", TOTAL_NUMBER);
    printf("die1 seed=%d : die2 seed=%d\n\n", SEED_ONE, SEED_TWO );

    printf("The cross sum of dice\n");
    for( i=0 ; i < TOTAL_NUMBER ; i++ ){
        cross_sum[(die_two[i]-1)][(die_one[i]-1)]++ ;
    }

    printf("   die1 |   (1)   (2)   (3)   (4)   (5)   (6)\n" ) ;
    printf("--------+--------------------------------------\n" ) ;
    for ( j = 0 ; j < 6 ; j++ ){
        sum = 0 ;
        printf("die2(%d) |", j + 1 ) ;
        for ( i = 0 ; i < 6 ; i++ ){
            printf("%6d", cross_sum[j][i] ) ;
            sum+=cross_sum[j][i] ;
        }
        printf("  :%6d\n", sum ) ;
    }
    printf("--------+--------------------------------------\n" ) ;
    printf("         ") ;
    for ( i = 0 ; i < 6 ; i++ ){
        sum = 0 ;
        for ( j = 0 ; j < 6 ; j++ ){
            sum+=cross_sum[j][i] ;
        }
        printf("%6d", sum ) ;
    }
    printf("\n");

/*   サイ１の推移表を表示する   */

    printf("\nThe sequence of die1\n");
    for( i=0 ; i < TOTAL_NUMBER-1 ; i++ ){
        sequence_one[(die_one[i+1]-1)][(die_one[i]-1)]++ ;
    }

    printf("   die1 |   (1)   (2)   (3)   (4)   (5)   (6)\n" ) ;
    printf("--------+--------------------------------------\n" ) ;
    for ( j = 0 ; j < 6 ; j++ ){
        sum = 0 ;
        printf("next(%d) |", j + 1 ) ;
        for ( i = 0 ; i < 6 ; i++ ){
            printf("%6d", sequence_one[j][i] ) ;
            sum+=sequence_one[j][i] ;
        }
        printf("  :%6d\n", sum ) ;
    }
    printf("--------+--------------------------------------\n" ) ;
    printf("         ") ;
    for ( i = 0 ; i < 6 ; i++ ){
        sum = 0 ;
        for ( j = 0 ; j < 6 ; j++ ){
            sum+=sequence_one[j][i] ;
        }
        printf("%6d", sum ) ;
    }
    printf("\n");

/*   サイ２の推移表を表示する   */

    printf("\nThe sequence of die2\n");
    for( i=0 ; i < TOTAL_NUMBER-1 ; i++ ){
        sequence_two[(die_two[i+1]-1)][(die_two[i]-1)]++ ;
    }

    printf("   die2 |   (1)   (2)   (3)   (4)   (5)   (6)\n" ) ;
    printf("--------+--------------------------------------\n" ) ;
    for ( j = 0 ; j < 6 ; j++ ){
        sum = 0 ;
        printf("next(%d) |", j + 1 ) ;
        for ( i = 0 ; i < 6 ; i++ ){
            printf("%6d", sequence_two[j][i] ) ;
            sum+=sequence_two[j][i] ;
        }
        printf("  :%6d\n", sum ) ;
    }
    printf("--------+--------------------------------------\n" ) ;
    printf("         ") ;
    for ( i = 0 ; i < 6 ; i++ ){
        sum = 0 ;
        for ( j = 0 ; j < 6 ; j++ ){
            sum+=sequence_two[j][i] ;
        }
        printf("%6d", sum ) ;
    }
    printf("\n");

/*   ３連続の出現表を表示する   */

    printf("\n3 sequence of die1  die2\n");
    for ( j = 0 ; j < 6 ; j++){
        sum1 = 0 ;
        sum2 = 0 ;
        for( i=0 ; i < TOTAL_NUMBER-2 ; i++ ){
            if ( die_one[i] == j + 1 && die_one[i+1] == j+1 && die_one[i+2] == j+1 ){
                sum1++ ;
            }
            if ( die_two[i] == j + 1 && die_two[i+1] == j+1 && die_two[i+2] == j+1 ){
                sum2++ ;
            }
        }
        printf("       %d%d%d %6d%6d\n", j+1,j+1,j+1,sum1, sum2 );
    }

/*   ４連続の出現表を表示する   */

    printf("\n4 sequence of die1  die2\n");
    for ( j = 0 ; j < 6 ; j++){
        sum1 = 0 ;
        sum2 = 0 ;
        for( i=0 ; i < TOTAL_NUMBER-3 ; i++ ){
            if ( die_one[i] == j + 1 && die_one[i+1] == j+1 && die_one[i+2] == j+1 && die_one[i+3] == j+1 ){
                sum1++ ;
            }
            if ( die_two[i] == j + 1 && die_two[i+1] == j+1 && die_two[i+2] == j+1 && die_two[i+3] == j+1 ){
                sum2++ ;
            }
        }
        printf("      %d%d%d%d %6d%6d\n", j+1,j+1,j+1,j+1,sum1, sum2 );
    }

/*   ５連続の出現表を表示する   */

    printf("\n5 sequence of die1  die2\n");
    for ( j = 0 ; j < 6 ; j++){
        sum1 = 0 ;
        sum2 = 0 ;
        for( i=0 ; i < TOTAL_NUMBER-4 ; i++ ){
            if ( die_one[i] == j + 1 && die_one[i+1] == j+1 && die_one[i+2] == j+1 && die_one[i+3] == j+1 && die_one[i+4] == j+1 ){
                sum1++ ;
            }
            if ( die_two[i] == j + 1 && die_two[i+1] == j+1 && die_two[i+2] == j+1 && die_two[i+3] == j+1 && die_two[i+4] == j+1 ){
                sum2++ ;
            }
        }
        printf("     %d%d%d%d%d %6d%6d\n", j+1,j+1,j+1,j+1,j+1,sum1, sum2 );
    }

/*   ６連続の出現表を表示する   */

    printf("\n6 sequence of die1  die2\n");
    for ( j = 0 ; j < 6 ; j++){
        sum1 = 0 ;
        sum2 = 0 ;
        for( i=0 ; i < TOTAL_NUMBER-5 ; i++ ){
            if ( die_one[i] == j + 1 && die_one[i+1] == j+1 && die_one[i+2] == j+1 && die_one[i+3] == j+1 && die_one[i+4] == j+1 && die_one[i+5] == j+1 ){
                sum1++ ;
            }
            if ( die_two[i] == j + 1 && die_two[i+1] == j+1 && die_two[i+2] == j+1 && die_two[i+3] == j+1 && die_two[i+4] == j+1 && die_two[i+5] == j+1 ){
                sum2++ ;
            }
        }
        printf("    %d%d%d%d%d%d %6d%6d\n", j+1,j+1,j+1,j+1,j+1,j+1,sum1, sum2 );
    }



    return 0;
}